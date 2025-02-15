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
