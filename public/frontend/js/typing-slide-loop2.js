var stringsTiming;
var stringsPause;
var content;
var section;

$(document).ready(function(){
    stringsTiming = 3000;
    stringsPause = 1000;
    content = $(".hidden-section>div").html();
    section = $(".visible-section").html(content).attr("class", "visible-section col-center padding-bottom");
});

function playAnimation(){
    $(".second", section).addClass("show");
    $(".second-typed-string", section).typed({
        strings: ["Experience"],
        typeSpeed: 200,
        startDelay: 1000,
        preStringTyped: function() {
            $(".second-typed-string", section).addClass("highlighted")
        }
    });
}

function playBottomAnimation(){
    $(".second", section).delay(0).queue(function(next){
        $(".first", section).addClass("show")
        next();
    }).delay(200).queue(function(next){
          $(".first-typed-string", section).addClass("highlighted")
        next();
    }).delay(200).queue(function(next){
          $('.first-typed-string').typeIt({
            speed: 200,
            lifeLike: false,
            autoStart: true,
              startDelete: true
          })
          .tiType('sketching')
          .tiPause(stringsPause);
        next();
    }).delay(200).queue(function(next){
          $(".third-typed-string", section).addClass("highlighted")
        next();
    }).delay(stringsTiming).queue(function(next){
        $(".third", section).addClass("show");
          $('.third-typed-string').typeIt({
            speed: 600,
            lifeLike: false,
            autoStart: false
          })
          .tiType(':)')
          .tiPause(stringsPause)
        next();
    }).delay(stringsTiming).queue(function(next){
          $('.first-typed-string').typeIt({
            speed: 200,
            lifeLike: false,
            autoStart: false
          })
          .tiType('coding')
          .tiPause(stringsPause)
        next();
    }).delay(stringsTiming).queue(function(next){
          $('.third-typed-string').typeIt({
            speed: 600,
            lifeLike: false,
            autoStart: false,
              html: true
          })
          .tiType('<33')
          .tiPause(stringsPause)
        next();
    }).delay(stringsTiming).queue(function(next){
          $('.first-typed-string').typeIt({
            speed: 200,
            lifeLike: false,
            autoStart: false
          })
          .tiType('envisioning')
          .tiPause(stringsPause)
        next();
    }).delay(stringsTiming).queue(function(next){
          $('.third-typed-string').typeIt({
            speed: 900,
            lifeLike: false,
            autoStart: false,
              html: true
          })
          .tiType(':D')
          .tiPause(stringsPause)
        next();
    }).delay(stringsTiming).queue(function(next){
          $('.first-typed-string').typeIt({
            speed: 200,
            lifeLike: false,
            autoStart: false
          })
          .tiType('prototyping')
          .tiPause(stringsPause)
        next();
    }).delay(stringsTiming).queue(function(next){
          $('.third-typed-string').typeIt({
            speed: 600,
            lifeLike: false,
            autoStart: false,
              html: true
          })
          .tiType('&lt;/&gt;')
          .tiPause(stringsPause)
        next();
    }).delay(stringsTiming).queue(function(next){
          $('.first-typed-string').typeIt({
            speed: 200,
            lifeLike: false,
            autoStart: false
          })
          .tiType('drawing')
        next();
    }).delay(stringsTiming).queue(function(next){
          $('.third-typed-string').typeIt({
            speed: 600,
            lifeLike: false,
            autoStart: false,
            html: true,
            callback: playBottomAnimation
            })
            .tiType(':p')
            .tiPause(stringsPause)
            .tiDelete()
            .tiType(';)')
         next(); 
    })
}
    

