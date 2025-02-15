package main

import (
	"fmt"
	"net/http"
	"time"
)

func handlerFunc(w http.ResponseWriter, r *http.Request) {
	fmt.Fprint(w, "<h1>Welcome to my awesome site!</h1>")
}

func performTask() {
	// Your specific task goes here
	fmt.Println("Performing the task at", time.Now())

	// Example list of URLs to check
	urls := []string{
		"http://msprabhakara.com",
		"http://demo.sopact.com",
		"http://ffp.sopact.com",
		"http://tbb.sopact.com",
		"http://kennedycenter.sopact.com",
		"http://survey.sopact.com",
		"http://sense-test.sopact.com",
		"http://ffafrica.sopact.com",
		"http://icff.sopact.com",
		"http://blackinnovation.sopact.com",
		"http://crossroads.sopact.com",
		"http://kuramo.sopact.com",
	}

	// Create a channel to synchronize the completion of all goroutines
	done := make(chan bool, len(urls))

	// Perform HTTP GET requests concurrently
	for _, url := range urls {
		go func(url string) {
			resp, err := http.Head(url)
			if err != nil {
				fmt.Printf("Error checking %s: %v\n", url, err)
			} else {
				fmt.Printf("Checked %s: %d at %s\n", url, resp.StatusCode, time.Now())
				resp.Body.Close()
			}
			// Signal that this goroutine has completed
			done <- true
		}(url)
	}

	// Wait for all goroutines to complete
	for i := 0; i < len(urls); i++ {
		<-done
	}
}

func main() {
	go func() {
		http.HandleFunc("/", handlerFunc)
		fmt.Println("Starting the server on :3000...")
		http.ListenAndServe(":3000", nil)
	}()

	// Create a ticker that triggers every 30 seconds
	ticker := time.NewTicker(30 * time.Second)
	defer ticker.Stop()

	// Perform the task immediately at startup
	performTask()

	go func() {
		for {
			select {
			case <-ticker.C:
				performTask()
			}
		}
	}()

	// Keep the main function running
	select {}
}
