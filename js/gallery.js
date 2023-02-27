var count = 0;
var splideIDs = [];
var accountName = "everton";
var fileDirectory = "images/instagram";

function galleryFromArray(arr){
    var section = 1;
    var rows = 6;
    var maxPerPage = 60;

    var totalSections = Math.ceil(arr.length/maxPerPage);
    var perPage = Math.ceil(arr.length/totalSections);

    console.log("Total Sections: "+totalSections+" Amount:" +arr.length+ " Per Page: "+maxPerPage, " Actual per page: "+perPage);


    var galleryMain = document.getElementById("gallery-main");
    var html = '<section class="splide splide-pagination" aria-label="Splide Basic HTML Example">'
                    +'<div class="splide__track">'
                        +'<ul id="gallery-pages" class="splide__list">';

    for( var i = 0; i < totalSections; i++){
        html += '<li class="splide__slide hide page-'+ (i+1) +'"></li>';
    }

        html            += '</ul>'
                    +'</div>'
                +'</section>';

                // console.log(html);

    galleryMain.innerHTML += html; html = "";
    // console.log(arr);
    var position = 0;
    for(let i = 0; i < arr.length; i++) {       
        // console.log("Count: "+count+ " Section: "+section);
        if(count == perPage){
            count = 0;
            section++;
        }
        if(count == 0){
            html = "<div class='page-content'>";
            for(var ie = 0; ie < rows; ie++){
                html += '<div class="column" id="col-'+ section + "-" + (ie+1) +'"></div>';
            }
            html += "</div>";
            document.getElementsByClassName('page-'+section)[0].innerHTML += html;
        }


        count++;
        position++;
        let galleryItem = arr[i];
        var gallery = new GalleryItem(galleryItem['date'], galleryItem['collection-size'], galleryItem['has-video'], galleryItem['position'], galleryItem['caption']);
        document.getElementById("col-"+section+"-"+position).innerHTML += gallery.getHTML();
        if(position == rows){
            position = 0;
            console.log(position+" "+rows)
        }
        // document.querySelectorAll('#section-'+section+' .col-'+galleryItem['position']).innerHTML +=  gallery.getHTML();
    }

    columnsHTML = '</ul></div></div>';
    galleryMain.innerHTML += columnsHTML;


}

class GalleryItem{
    constructor(dateString, collectionLength, hasVideo, position, caption){
        this.dateString = dateString;
        this.accountName = accountName;
        this.collectionLength = collectionLength; 
        this.hasVideo = hasVideo;
        this.position = position;
        this.caption = caption;
    }

    getName(){
        return this.accountName;
    }

    getDate(){
        return this.dateString;
    }

    getID(){
        var id = this.dateString.replaceAll("-", "");
        id = id.replaceAll("_", "");
        return id;
    }

    getAccountName(){
        return this.accountName;
    }

    getPosition(){
        return this.position;
    }

    getCollectionSize(){
        return this.collectionLength;
    }

    getCaption(){
        return this.caption;
    }

    hasMp4(){
        return this.hasVideo;
    }

    getHTML(){
        var html = "";

        if(this.getCollectionSize() == 0){
            if(this.hasMp4() == true){
                html +='<a class="video" onclick="expandVideo(this.firstElementChild)"><img src="'+fileDirectory+'/'+this.getDate()+'_UTC.jpg" caption="'+this.getCaption()+'" class="gallery-item clickable-img" /></a>'
            }else{
                html +='<img src="'+fileDirectory+'/'+this.getDate()+'_UTC.jpg" class="gallery-item clickable-img" caption="'+this.getCaption()+'" loading="lazy" />'
            }
        }else{
            var splideHTML = '<section class="gallery-collection splide splide-'+this.getID()+'">'
                            +'<div class="splide__track">'
                                +'<ul class="splide__list">';

                for(var i = 1; i < this.getCollectionSize() + 1; i++){
                    splideHTML += '<li class="splide__slide">'
                                +'<img src="'+fileDirectory+'/'+this.getDate()+'_UTC_'+(i)+'.jpg" caption="'+this.getCaption()+'" class="collection-item clickable-img" loading="lazy" alt="">'
                            +'</li>';
                }

                splideHTML += '</ul>'
                        +'</div>'
                    +'</section>'
            html += splideHTML;

            splideIDs.push(this.getID());

        }

        // console.log(html)
        return html;
    }
}

window.addEventListener('load', 
    function() { 
        var images = document.getElementsByClassName("clickable-img");
        for ( var i = 0; i < images.length; i++ ) (function(i){ 
            images[i].onclick = function() {
                // console.log(images[i].getAttribute('src'));

                var img = document.getElementById("popoutImage");
                img.setAttribute('src', images[i].getAttribute('src'));

                var caption = document.getElementById("caption");
                console.log(images[i].getAttribute("caption"));
                caption.innerHTML = images[i].getAttribute("caption");

                togglePopout();
            }
        var popoutExit = document.getElementById("exit");
        popoutExit.onclick = function() {
            togglePopout(false);
        }
        })(i);

    splideIDs.forEach(element => {
        var splide = new Splide(".splide-"+ element ); 
        splide.mount(); 
    });

    var splide = new Splide( '.splide-pagination', {
        perPage: 1,
        drag: false,
        classes: {
            pagination: ' gallery-pagination',
            page      : ' gallery-pagination-page',
            prev  : 'splide__arrow--prev gallery-prev',
            next  : 'splide__arrow--next gallery-next',
        },
    } );

    splide.on( 'pagination:mounted', function ( data ) {
        data.items.forEach( function ( item ) {
            item.button.textContent = String( item.page + 1 );
        } );
    } );
    
    splide.mount();
});

function expandVideo(child){
    var video = document.getElementById("popoutVideo");
    video.setAttribute('display', "none");
    video.setAttribute('src', child.getAttribute('src').replace(".jpg", ".mp4"));
    
    var caption = document.getElementById("caption");
    console.log(child.getAttribute("caption"));
    caption.innerHTML = child.getAttribute("caption");
    togglePopout(true);
}

function togglePopout(isVideo){
    const popOutScreen = document.querySelector('#popout');
    const isOpened = popOutScreen.getAttribute('aria-expanded');

    if(isOpened === 'false'){
        popOutScreen.setAttribute('aria-expanded', 'true');
        popOutScreen.setAttribute('style', 'display: flex;');
        if(isVideo){
            var element = document.getElementById("popoutVideo");
            element.setAttribute('style', 'display: block;');
        }else{
            var element = document.getElementById("popoutImage");
            element.setAttribute('style', 'display: block;');
        }
    }else{
        popOutScreen.setAttribute('aria-expanded', 'false');
        popOutScreen.setAttribute('style', 'display: none;');
        
        var img = document.getElementById("popoutImage");
        img.setAttribute('style', 'display: none;');
        
        var video = document.getElementById("popoutVideo");
        video.setAttribute('style', 'display: none;');

        $('#caption').width($('#popoutImage').width());
        // var caption = document.getElementById("caption");
        // caption.innerHTML = 
    }
}
