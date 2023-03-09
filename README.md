# Php-Instagram-Gallery

Uses [Instaloader](https://github.com/instaloader) python library to scrape instagram posts for download. 
Uses PHP&Javascript to sort and display downloaded content in a gallery format.

- Displays instagram posts from a selected user
- Maintains collections from instagram for photo groups 
- Splits equally into set amount of columns (configurable) 
- Display configurable amount per-page
- Uses splide library to create image carousels for instagram photo collections (posts with more than 1 image)
- Displays thumbnail for video posts
- Expanded view on clicking an image/video post 
- Displays caption from instagram post

I used this gallery in a project!
[View Live Example](http://www.jordheyeshair.co.uk/gallery.php)

## Example Screens
![Gallery screen](https://i.imgur.com/PbwryNd.png "Gallery screen")

![Expanded screen](https://i.imgur.com/JniOwlq.png "Expanded screen")

## Instaloader Script

Python Script
```
import instaloader
loader = instaloader.Instaloader()
loader.save_metadata = False;
loader.dirname_pattern = "D:\\Websites\\Php Instagram Gallery\\images\\instagram";
profile = instaloader.Profile.from_username(loader.context, "everton");
loader.posts_download_loop(target= profile.username, posts=profile.get_posts(), fast_update=True);
```

Or 

Terminal Script
```
instaloader --fast-update everton --login username --password password
```
Downloads all photos from the given instagram user. E.g.
```
//regular post
2022-12-31_18-13-43_UTC.txt
2022-12-31_18-13-43_UTC.jpg

//collection post
2022-12-26_14-14-01_UTC.txt
2022-12-26_14-14-01_UTC_1.jpg
2022-12-26_14-14-01_UTC_2.jpg
2022-12-26_14-14-01_UTC_3.jpg

//video post
2022-12-27_14-14-01_UTC.txt
2022-12-27_14-14-01_UTC.jpg
2022-12-27_14-14-01_UTC.mp4
```

"Fast update" used to only download new posts, the script will stop upon reaching a post it has already downloaded.

## PHP 
```
$files = glob(dirname(realpath(__DIR__)).'/'.$file_directory.'/*');
foreach($files as $filepath) {
    $filename = basename($filepath);

    //trim the date from the file name for the file key
    $date = strstr($filename, '_UTC', true);
    
    // Look for array entry with the date as the key, if not initalize with default values
    $array[$date] ??= [
        'date' => $date,
        'caption' => '',
        'collection-size' => 0,
        'has-video' => false,
    ];
    
    // File extension of said file
    $ext = strtolower(pathinfo($filepath, PATHINFO_EXTENSION));
    
    if($ext === 'jpg'){
        // Each JPG increments collection size
        $array[$date]['collection-size']++;
    }
    
    elseif ($ext === "txt"){
        // if .txt is present add caption to entry by date
        $caption = file_get_contents($filepath);
        $array[$date]['caption'] = $caption;

    } elseif($ext === 'mp4'){
        // if .mp4 is present, has-video set to true
        $array[$date]['has-video'] = true;
    }
}
```
Array send to client through javascript to be displayed. 
