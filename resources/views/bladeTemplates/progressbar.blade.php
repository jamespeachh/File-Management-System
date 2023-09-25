<style>
    body, .jumbotron{
   background: rgb(235, 226, 226);
      padding: 100px;
    }
    .content{
      background: #fff;
      padding: 50px;
      font-size: 19px;
      line-height: 30px;
      min-height: 3000px;   
    }

    .scroll-line{
    background: purple;
      top: 0;
      left: 0;
      height: 10px;
      position: fixed;
      transition: 0.5s cubic-bezier(0.075, 0.82, 0.165, 1);
    }
</style>

<script>
    const scrollline = document.querySelector('.scroll-line');

    function fillscrollline(){
        const windowHeight = window.innerHeight;
        const fullHeight = document.body.clientHeight;
        const scrolled = window.scrollY;
        const percentScrolled = (scrolled / (fullHeight - windowHeight)) * 100;

        scrollline.style.width = percentScrolled + '%';
    };

window.addEventListener('scroll', fillscrollline);
</script>

<div class="progress-bar"></div>