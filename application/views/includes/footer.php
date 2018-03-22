<!-- Footer Start here -->
<footer>
    <div class="overlay home-six-overlay">
        <div class="container">
            <h2>California Cannabis Awards</h2>
            <ul class="event-social">
                <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                <li><a href="#"><i class="fa fa-dribbble" aria-hidden="true"></i></a></li>
                <li><a href="#"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li>
                <li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
            </ul>
            <p>Copyright &copy; 2018. Powered By WebJoint - <a href="https://www.codexcoder.com/">Cannabis Software</a></p>
        </div>
    </div>
</footer>
<!-- Footer End here -->
</div>


<!-- jQuery -->
<script src="<?= site_url();?>assets/js/jquery-3.1.1.min.js"></script>
<script src="<?= site_url();?>assets/js/jquery-migrate-1.4.1.min.js"></script>

<!-- Bootstrap -->
<script src="<?= site_url();?>assets/js/bootstrap.min.js"></script>

<!-- Coundown -->
<script src="<?= site_url();?>assets/js/jquery.countdown.min.js"></script>

<!--Swiper-->
<script src="<?= site_url();?>assets/js/swiper.jquery.min.js"></script>

<!--Masonry-->
<script src="<?= site_url();?>assets/js/masonry.pkgd.min.js"></script>

<!--Lightcase-->
<script src="<?= site_url();?>assets/js/lightcase.js"></script>

<!--modernizr-->
<script src="<?= site_url();?>assets/js/modernizr.js"></script>

<!--velocity-->
<script src="<?= site_url();?>assets/js/velocity.min.js"></script>

<!--quick-view-->
<script src="<?= site_url();?>assets/js/quick-view.js"></script>

<!--nstSlider-->
<script src="<?= site_url();?>assets/js/jquery.nstSlider.js"></script>
<script src="<?= site_url();?>assets/js/nstfunctions.js"></script>

<!--flexslider-->
<script src="<?= site_url();?>assets/js/flexslider-min.js"></script>
<script src="<?= site_url();?>assets/js/flexfunctions.js"></script>

<!--directional-->
<script src="<?= site_url();?>assets/js/directional-hover.js"></script>

<!--easing-->
<script src="<?= site_url();?>assets/js/jquery.easing.min.js"></script>

<!-- Google Map -->
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAQlXnmyNPAeN3c3HNyWoUMqDk6bDF31Cg"></script>

<!-- Voting script -->
<script src="https://surveyjs.azureedge.net/1.0.14/survey.jquery.min.js"></script>

<!-- Custom -->
<script src="<?= site_url();?>assets/js/custom.js"></script>

<script type="text/javascript">

    //Home Page map
    var styleArray = [
        {
            "featureType": "water",
            "elementType": "geometry.fill",
            "stylers": [
                {
                    "color": "#65ac4c"
                }
            ]
        }
    ];

    var mapOptions = {
        center: new google.maps.LatLng(34.0447954,-118.2652703),
        zoom: 09,
        styles: styleArray,
        scrollwheel: false,
        backgroundColor: 'transparent',
        mapTypeControl: false,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(document.getElementById("home-map"),
        mapOptions);
    var myLatlng = new google.maps.LatLng(34.0447954,-118.2652703);
    var marker = new google.maps.Marker({
        position: myLatlng,
        map: map,
        icon: 'images/map-icon.png'
    });



    //Travel map
    var styleArray = [
        {
            "featureType": "water",
            "elementType": "geometry.fill",
            "stylers": [
                {
                    "color": "#65ac4c"
                }
            ]
        }
    ];

    var mapOptions = {
        center: new google.maps.LatLng(34.0447954,-118.2652703),
        zoom: 09,
        styles: styleArray,
        scrollwheel: false,
        backgroundColor: 'transparent',
        mapTypeControl: false,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(document.getElementById("map_canvas"),
        mapOptions);
    var myLatlng = new google.maps.LatLng(34.0447954,-118.2652703);
    var marker = new google.maps.Marker({
        position: myLatlng,
        map: map,
        icon: 'images/map-icon.png'
    });

</script>

<script>
    Survey.Survey.cssType = "bootstrap";
    var surveyJSON = JSON.parse('<?php echo json_encode($surveyJSON); ?>');
    var survey = new Survey.Model(surveyJSON);
    survey
        .onComplete
        .add(function(result) {
            //send Ajax request to your web server.
            $.ajax({
                url: "<?php echo site_url() ?>vote/getsurvey",
                method: "POST",
                data: result.data,
                dataType: "text",
                success: function (data)
                {
                    console.log(data);
                    if (data == "voter_exist") {
                        survey.completedHtml = "<p><h3>It looks like you have already voted.</h3></p>";
                        survey.render();
                        }
                }
            });
        });
    if (surveyJSON.pages.length > 0) {
        $("#surveyContainer").Survey({
            model: survey,
        });
    } else {
        $('#surveyContainer').html('<p><h3>It looks like you have already voted.</h3></p>');
    }
    //For Responsive
    $(document).ready(function() {
        var elements = survey.getAllQuestions();
        for (var i in elements) {
            if ($(window).width() < 768)
                elements[i].colCount = 1;
            else
                elements[i].colCount = 4;
        }
        survey.render();
    });
    $(window).resize(function() {
        var elements = survey.getAllQuestions();
        for (var i in elements) {
            if ($(window).width() < 768)
                elements[i].colCount = 1;
            else
                elements[i].colCount = 4;
        }
        survey.render();
    });
    // adding loading image
    $(window).load(function() {
        $(".loader").hide();
    });


</script>



</body>
</html>