package main

import (
	"database/sql"
	"fmt"
	"log"
	"net/http"
	"runtime"
	"strconv"
	"sync"
	"time"

	_ "github.com/jackc/pgx/v4/stdlib"
)

func handlerFunc(w http.ResponseWriter, r *http.Request) {
	fmt.Fprint(w, "<h1>Welcome to my awesome site!</h1>")
}

func performTask(db *sql.DB) {
	// Your specific task goes here
	fmt.Println("Performing the task at", time.Now().Format("2006-01-02 15:04:05"))
	start := time.Now()
	// Example list of URLs to check
	rows, err := db.Query("SELECT id, url, team_id FROM public.trackers where is_active != false and is_archived = false")

	if err != nil {
		log.Fatal(err)
	}
	defer rows.Close()
	// Create a WaitGroup to synchronize the completion of all goroutines
	var wg sync.WaitGroup

	// Iterate over the rows and print the results
	for rows.Next() {
		var id int
		var url string
		var team_id int
		err := rows.Scan(&id, &url, &team_id)
		if err != nil {
			log.Fatal(err)
		}
		// Increment the WaitGroup counter
		wg.Add(1)
		go func(url string) {
			defer wg.Done()
			startTimeWTz := time.Now().Format("2006-01-02 15:04:05")
			startTime := time.Now()
			startTimeEpoch := startTime.Unix()
			resp, err := http.Head(url)
			endTime := time.Now()
			endTimeEpoch := endTime.Unix()
			responseTime := time.Since(startTime).Seconds()
			endTimeWTz := time.Now().Format("2006-01-02 15:04:05")
			if err != nil {
				fmt.Printf("Error checking %s: %v\n", url, err)
				// Insert the event into tracker_events table
				_, err := db.Exec("INSERT INTO tracker_events (tracker_id, response_time, http_status_code, message, start_time, end_time,epoch_start_time, epoch_end_time, exception, created_at, updated_at) VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11)",
					id, responseTime, "500", err.Error(), startTimeWTz, endTimeWTz, startTimeEpoch, endTimeEpoch, err.Error(), startTimeWTz, startTimeWTz)
				if err != nil {

					log.Printf("Error inserting event for %s: %v\n", url, err)
				}
			} else {
				timestamp := time.Now().Format("2006-01-02 15:04:05")
				statusCodeStr := strconv.Itoa(resp.StatusCode)
				_, err := db.Exec("INSERT INTO tracker_events (tracker_id, response_time, http_status_code, message, start_time, end_time,epoch_start_time, epoch_end_time, exception, created_at, updated_at) VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11)",
					id, responseTime, statusCodeStr, "Success", startTimeWTz, endTimeWTz, startTimeEpoch, endTimeEpoch, "", startTimeWTz, startTimeWTz)
				if err != nil {
					log.Printf("Error inserting event for %s: %v\n", url, err)
				}
				fmt.Printf("Checked %s: %d at %s\n", url, resp.StatusCode, timestamp)
				resp.Body.Close()
			}
			fmt.Printf("Goroutine ended at: %s, Number of goroutines: %d\n", endTimeWTz, runtime.NumGoroutine())
		}(url)
	}

	// Check for errors from iterating over rows
	err = rows.Err()
	if err != nil {
		log.Fatal(err)
	}

	// Wait for all goroutines to complete
	wg.Wait()
	fmt.Println("Done with everything", time.Now().Format("2006-01-02 15:04:05"))
	duration := time.Since(start)
	fmt.Println("Duration:", duration)
}

func main() {
	//Connect to the db
	db, err := sql.Open("pgx", "host=ar_postgres port=5432 user=postgres password=password dbname=appsare sslmode=disable")
	defer db.Close()
	err = db.Ping()
	if err != nil {
		panic(err)
	}
	fmt.Println("Connected!")
	// Create a ticker that triggers every 30 seconds
	ticker := time.NewTicker(30 * time.Second)
	defer ticker.Stop()

	// Perform the task immediately at startup
	performTask(db)

	go func() {
		for {
			select {
			case <-ticker.C:
				performTask(db)
			}
		}
	}()

	// Keep the main function running
	select {}
}
