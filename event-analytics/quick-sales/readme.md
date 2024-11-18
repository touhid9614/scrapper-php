### Steps
Step 1: List all the vehicles URLs from a dealership
Step 2: Estimate Dates of each Friday for last one month
Step 3: For each point in time (Friday 05:00PM), Calculate all events for each VDP.
Step 4: Coorelate if the vehicle was sold on the next week
Step 5: Store the data in a CSV file for training

Note: Anything Sold before 7th September shall be ignored because we won't have enough data to create a cooralation

### Data
| Number of Unique Users | Number of Pageviews | Total Time on Page (Each PageView is capped to 5 minutes) | Number of PageViews with more than 30 seconds on page | Number of Clicks | Year | Make | Model | Price | Sold on Next Week |