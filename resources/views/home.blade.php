<style>

h5 {
    text-indent: 30px;
}

</style>

<x-home_layout>
<div class="custom-homepage-container">

    <div class="container" style = "margin:20px; max-width:1500px;">
        <div class="card p-4  custom-card-container">
            <h2 class="mb-4">Welcome to my website,</h2>
            <h5>
                I'm a PhD Researching in Applied Beam Physics at UCLA, working in the Particle Beam and Physics Laboratory (PBPL) under 
                my advisor, Pietro Musumeci.
            <h5>
                My journey in physics has given me the opportunity to explore a variety of skills from 
            mechanical design, machining, and electronics to programming, machine learning, and data analysis. 
            I'm always working on personal projects to develop new skills and designing/hosting this website on my own raspberrypi server
            was a necessary step to add database communication and storage capabilities for my current and future projects.
            </h5>
            <h5>
                I'm looking to pursue a career in data science where I can leverage my theoretical and applied background to tackle interesting problems.
                Feel free to look around, or check out my 
                <a target="_blank" href="https://github.com/afisher000" class="custom-link">Github</a> and connect on 
                <a target="_blank" href="https://www.linkedin.com/in/afisher000" class="custom-link">LinkedIn</a>.
            </h5>
            <h1 style="font-family: 'Dancing Script', cursive;">
                -Andrew Fisher
            </h1>

        </div>
        

    </div>


    <div id="slideshow" class="carousel slide carousel-fade p-4" data-mdb-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="{{ asset('images/slideshow/thanksgiving2022Final.jpg') }}">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="{{ asset('images/slideshow/cncFinal.jpg') }}">
                <div class="carousel-caption d-none d-md-block">
                    <p style="color:#F0ECE9; margin-bottom:0rem;">Homemade CNC</p>
                </div>
            </div>

            <div class="carousel-item">
                <img class="d-block w-100" src="{{ asset('images/slideshow/pulsewireChicagoFinal.jpg') }}">
                <div class="carousel-caption d-none d-md-block">
                    <p style="color:#F0ECE9; margin-bottom:0rem;">Magnetic Measurements at Fermilab</p>
                </div>
            </div>

            <div class="carousel-item">
                <img class="d-block w-100" src="{{ asset('images/slideshow/controlRoomFinal.jpg') }}">
                <div class="carousel-caption d-none d-md-block">
                    <p style="color:#F0ECE9; margin-bottom:0rem;">Pegasus Control Room</p>
                </div>
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="{{ asset('images/slideshow/gonzagaGameFinal.jpg') }}">
                <div class="carousel-caption d-none d-md-block">
                    <p style="color:#F0ECE9; margin-bottom:0rem;">Gonzaga (1) vs UCLA (2)</p>
                </div>
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="{{ asset('images/slideshow/mammothSummitFinal.jpg') }}">
                <div class="carousel-caption d-none d-md-block">
                    <p style="color:#F0ECE9; margin-bottom:0rem;">Mammoth Mountain Summit</p>
                </div>
            </div>

            <div class="carousel-item">
                <img class="d-block w-100" src="{{ asset('images/slideshow/halfdomeFinal.jpg') }}">
                <div class="carousel-caption d-none d-md-block">
                    <p style="color:#F0ECE9; margin-bottom:0rem;">Hiking in Yosemite</p>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#slideshow" role="button" data-slide="prev" >
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only"></span>
        </a>
        <a class="carousel-control-next" href="#slideshow" role="button" data-slide="next" >
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only"></span>
        </a>
        </div>
</div>

{{-- start carousel --}}
<script>
    $('.carousel').carousel()
</script>


</x-home_layout>