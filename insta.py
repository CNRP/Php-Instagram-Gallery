import instaloader

loader = instaloader.Instaloader()
loader.save_metadata = False;
loader.dirname_pattern = "D:\\Websites\\Php Instagram Gallery\\images\\instagram";
profile = instaloader.Profile.from_username(loader.context, "everton");

loader.posts_download_loop(target= profile.username, posts=profile.get_posts(), fast_update=True);