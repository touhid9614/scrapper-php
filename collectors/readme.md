# Shall contain all the collector Processes to sync data from Redis

1. Sync User -> Sessions -> PageViews -> Events in file system
    1. Sessions -> PageViews -> Events can be partitioned by dates

    2. Users can't be partitioned by dates, need a different mechanism, users
       shall be stored globally for all dealerships regardless of the domains
       they visited.

       Users shall be partitioned by the first two character of their Ids making
       1296 possible files to store all users.
2. Sync Engaged users to file system
