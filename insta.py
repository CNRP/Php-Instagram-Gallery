# from itertools import islice
# from math import ceil

# from instaloader import Instaloader, Profile

# PROFILE = "everton"        # profile to download from
# X_percentage = 10    # percentage of posts that should be downloaded

# L = Instaloader()

# profile = Profile.from_username(L.context, PROFILE)
# posts_sorted_by_likes = sorted(profile.get_posts(),
#                                key=lambda p: p.likes + p.comments,
#                                reverse=True)

# # for post in islice(posts_sorted_by_likes, ceil(profile.mediacount * X_percentage / 100)):
# #     L.download_post(post, PROFILE)

# import instaloader

# # Get instance
# L = instaloader.Instaloader()

# USER = "connorpefc";
# PASSWORD = "!123Acer123";

# # Optionally, login or load session
# # L.login(USER, PASSWORD)        # (login)
# # L.interactive_login(USER)      # (ask password on terminal)
# # L.load_session_from_file(USER) # (load session created w/
# #                                #  `instaloader -l USERNAME`)
# profile = instaloader.Profile.from_username(L.context, "everton")
# for post in profile.get_posts():
#     L.fast_update = True
#     L.download_post(post, target=profile.username)

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