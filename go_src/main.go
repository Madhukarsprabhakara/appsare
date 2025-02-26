package main

import (
	"database/sql"
	"fmt"
	"log"
	"net/http"
	"sync"
	"time"

	_ "github.com/jackc/pgx/v4/stdlib"
)

func handlerFunc(w http.ResponseWriter, r *http.Request) {
	fmt.Fprint(w, "<h1>Welcome to my awesome site!</h1>")
}

func performTask(db *sql.DB) {
	// Your specific task goes here
	fmt.Println("Performing the task at", time.Now())
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
			resp, err := http.Head(url)
			if err != nil {
				fmt.Printf("Error checking %s: %v\n", url, err)
			} else {
				fmt.Printf("Checked %s: %d at %s\n", url, resp.StatusCode, time.Now())
				resp.Body.Close()
			}

		}(url)
	}

	// Check for errors from iterating over rows
	err = rows.Err()
	if err != nil {
		log.Fatal(err)
	}

	// Wait for all goroutines to complete
	wg.Wait()
	fmt.Println("Done with everything", time.Now())
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
