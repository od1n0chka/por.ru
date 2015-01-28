
</body>
</div>
<script type="text/javascript" language="javascript">
	$("#loader-wrapper").css('display','block');
	$(".header").css('position','relative');
	$(".header").css('top','-200px');
	$(".header").css('width','200px');
	$("ul.menu > li").css('display','none');
	$(".container").css('position','relative');
	$(".container").css('left','150%');
	$(".footer").css('position','relative');
	$(".footer").css('right','150%');
	$(".box").css('opacity','0');
	$("body ").css('overflow','hidden');
	$(window).load(
    	function() {
        	$("#loader-wrapper").animate({opacity:"0"},2000, function() {
				$("#loader-wrapper").css('display','none');
				$(".header").animate({top: "0px"},1000, function() {
					$(".header").animate({width: $(".wrapper").width()-16},1000, function() {
						$(".header").css('width','auto');
						$("ul.menu > li").fadeIn(1500);
					});
				});
				$(".container").animate({left: "0px"},2400,function() {
					$( '.container' ).masonry( { itemSelector: '.box' } );
								$(".box:eq(0)").animate({opacity:'1'},500, function () {
								$( '.container' ).masonry( { itemSelector: '.box' } ); 
								$(this).next('.box').animate({opacity:'1'},500, arguments.callee);
								$("body ").css('overflow','auto');
							});
				});
				$(".footer").animate({right: "0px"},2400);
			});
    	}
	);
	$(".box").click(function () {
		$(".box-container", this).removeClass("box-container").addClass( "box-container-opened" );
		$(".box-container-opened", this).animate({width:'80%'},500, function () {
			$(".box-container-opened", this).animate({height:'100%'},500, function () {
				
			});
		});
		/*$(".box-container", this).css('position','fixed');
		$(".box-container", this).css('top','0');
		$(".box-container", this).css('left','0');
		$(".box-container", this).css('width','80%');
		$(".box-container", this).css('margin','0% 10% 0% 10%');
		$(".box-container", this).css('height','100%');
		$(".box-container", this).css('z-index','999');
		$(".box-container", this).css('background-color','black');
		$(".box-container .image", this).css('width','50%;');*/
	});
</script>
<?php wp_footer(); ?>