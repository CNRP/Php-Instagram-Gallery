from datetime import datetime
from itertools import dropwhile, takewhile

import instaloader

L = instaloader.Instaloader()

posts = instaloader.Profile.from_username(L.context, "everton").get_posts()

SINCE = datetime(2022, 12, 1)
UNTIL = datetime(2023, 1, 11)

for post in takewhile(lambda p: p.date > UNTIL, dropwhile(lambda p: p.date > SINCE, posts)):
    print(post.date)
    L.fast_update = True
    L.save_metadata_json = False
    L.download_post(post, "everton")
