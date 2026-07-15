<!-- <body class="basic-page"> -->

    
<?php $desktop_banner = get_image('page/'.$pageData['id'].'-header-image');
       $mobile_banner = get_image('page/'.$pageData['id'].'-mobile-header-image');
       if (strlen($desktop_banner)) { ?>
            <div class="container">
                <div class="banner">
        
                
                    
                    <div class="hero-banner position-relative">
                        <img src="<?= $desktop_banner;?>" class="d-none d-sm-block w-100" />
                        <img src="<?= $mobile_banner;?>" class="d-block d-sm-none w-100" />
                       
                            <div class="hero-caption-inner">
                                <h1><?= $pageData['h1_title'] ;?></h1>
                            </div>
                  
                    </div>
               

             </div>
            </div>
        <?php } else { 

            include('includes/template-parts/sections/basic-page-title.php'); 

        } ?>
    <main>
       <div id="gallery"></div>
    </main>
<!-- </body> -->
<style>
  
#gallery .header{
    position: fixed;
    width:100%;
    height: 100px;
    display: flex;
    align-items: center;
    padding :0 2vw ;
    z-index: 10;
    background-color: #161616;
    opacity: 1;
}
#gallery {
    position: relative;
    width: 100%;
    display: flex;
    gap: 10px;
    padding: 25px 2vw 50px;
}
#gallery .column{
    flex:1;
    display: flex;
    flex-direction: column;
    gap:10px;
}
#gallery .post{
    position: relative;
    overflow: hidden;
    width:100%;
}

#gallery img{
    width: 100%;
    border-radius: 5px;
    height: 100%;
}

.overlay{
    position: absolute;
    top:0;
    left: 0;
    width:100%;
    height:100%;
    background:#161616;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity:0;
    transition:0.5s;
    border-radius: 5px;
}

.post:hover .overlay{
    opacity: 0.5;
    cursor: pointer;
}
</style>
<?php $photos = table_fetch_rows('gallery_photos','','');
$images = [];
foreach($photos as $photo) {
    $images[] = 'uploads/gallery_photos/'.$photo['filename'];
} ?>
<script>
   
        const posts = [];
        const images = [
            '<?= implode('\',\'',$images); ?>'
        ];

        let imageIndex = 0;

        for (let i = 1; i <= <?= count($photos); ?>; i++) {
          let item = {
            id: i,
            title: `Post ${i}`,
            image: images[imageIndex],
          };
          posts.push(item);
          imageIndex++;
          if (imageIndex > images.length - 1) imageIndex = 0;
        }

        const container = document.querySelector('#gallery');

        function generateMasonryGrid(columns, posts) {
          container.innerHTML = '';

          //Store column arrays that contain relevant posts
          let columnWrappers = {};

          //Create column item array and  add this to column wrapper object
          for (let i = 0; i < columns; i++) {
            columnWrappers[`column${i}`] = [];
          }
          for (let i = 0; i < posts.length; i++) {
            const column = i % columns;
            columnWrappers[`column${column}`].push(posts[i]);
          }
          for (let i = 0; i < columns; i++) {
            let columnPosts = columnWrappers[`column${i}`];
            let column = document.createElement('div');
            column.classList.add('column');
            columnPosts.forEach((posts) => {
              let postDiv = document.createElement('div');
              postDiv.classList.add('post');
              
              let image = document.createElement('img');
              image.src = posts.image;
              let link = document.createElement('a');
              link.setAttribute('data-fancybox','');
              link.setAttribute('href',posts.image);
   
              let overlay = document.createElement('div');
              overlay.classList.add('overlay');
              let title = document.createElement('h3');
              title.innerText = posts.title;

              overlay.appendChild(title);
              
              link.appendChild(image, overlay);
              postDiv.append(link);
              column.appendChild(postDiv);
            });
            container.appendChild(column);
          }
        }

        let previousScreenSize = innerWidth;
        console.log(previousScreenSize);

        window.addEventListener('resize', () => {
          imageIndex = 0;
          if (innerWidth < 600 && previousScreenSize >= 600) {
            generateMasonryGrid(1, posts);
          } else if (
            innerWidth >= 600 &&
            innerWidth < 1000 &&
            (previousScreenSize < 600 || previousScreenSize >= 1000)
          ) {
            generateMasonryGrid(2, posts);
          } else if (innerWidth >= 1000 && previousScreenSize < 1000) {
            generateMasonryGrid(4, posts);
          }
          previousScreenSize = innerWidth;
        });

        //Page Load
        if (previousScreenSize < 600) {
          generateMasonryGrid(1, posts);
        } else if (previousScreenSize >= 600 && previousScreenSize < 1000) {
          generateMasonryGrid(2, posts);
        } else {
          generateMasonryGrid(4, posts);
        }

</script>
