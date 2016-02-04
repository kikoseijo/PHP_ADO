<?php 

class BannerSlider
{
	
	
	var $color = array('0'=>'light-color', '1'=>'medium-color', '2'=>'dark-color'),
			$background = array('0'=>'sin background', '1'=>'dark-bg', '2'=>'light-bg'),
			$pos_x = array('0'=>'text-left', '1'=>'text-center', '2'=>'text-right'),
			$pos_y = array('0'=>'vertical-top', '1'=>'vertical-center', '2'=>'vertical-bottom');
	
	
   function BannerSlider() {
		 
		 
	 }
	 
	 
	 function buildHomeSlider(){
		global $a;
		$sliders = $a->sliders->select(" active='1' AND FIND_IN_SET(webs_id,".WEB_ID.")","orden asc, id desc");
		if ($sliders && $sliders->num_rows()>0){
			$i=0; $res='';
			while($sliders->fetch($slide)){
				$res.= $this->buildSlide($slide);
			}
		}
		 return $res;
	 }
	 
	 
	 private function buildSlide($slider){
		 if (!$slider) $slider=new Sliders();
		 
		 $res='';
		 $res.='<div class="item" style="background-image: url(dbfiles/sliders/'.$slider->img.');">';
		 $res.='<div class="container">';
		 if ($slider->title<>'' || $slider->subtitle<>''){
			 	$res.='<div class="caption '.$this->getClass('pos_y',$slider->pos_y).' '.$this->getClass('pos_x',$slider->pos_x).'">';
				/*Titulo*/
			 	if(trim($slider->title)<>''){
					$bg_color = $this->getClass('background',$slider->title_bg);
					$color_text = $this->getClass('color',$slider->title_color);
				 	$res.='<h1 class="fadeInDown-1 '.$bg_color.' '.$color_text.'">';
					if ($slider->title_bg>0)
						$res.= '<span>' .$slider->title . '</span>';
					else 
						$res.= $slider->title;
					
					$res.='</h1>';
					
				}
			 	if(trim($slider->subtitle)<>'')
			 		$res.='<p class="fadeInDown-2 '.$this->getClass('color',$slider->subtitle_color).'">'.$slider->subtitle.'</p>';
			  if($slider->btn<>''){
					$res.='<div class="fadeInDown-3">';
					$res.='<a href="'.$slider->btn_link.'" class="btn btn-large">'.$slider->btn.'</a>';
					$res.='</div><!-- /.fadeIn -->';
				}
			 $res.='</div><!-- /.caption -->';
		 }
		 $res.='</div><!-- /.container -->';
		 $res.='</div><!-- /.item -->';
		 
		 
		 $res.='';
		 $res.='';
		 $res.='';
		 $res.='';
		 $res.='';
		 $res.='';
		 $res.='';
		 $res.='';
		 
		 return $res;
		 
		 
	 }
	 
	 
	 private function getClass($object,$position){
		 $res='';
		 $theArray = $this->$object;
			if ($position >= 0 && $position < count($theArray)){
				return $theArray[$position];
			}
				
		 return $res;
	 }
	 
	 
		 
	function sliderHome(){
	?>
  
  
  
 
					
					
						
							
								
								
								
								
									
								
								
							
						
					
					
					<div class="item img-bg img-bg-soft light-bg" style="background-image: url(assets/images/art/slider03.jpg);">
						<div class="container">
							<div class="caption vertical-center text-left">
								
								<h1 class="fadeInLeft-1 dark-color">Caption <br>left center</h1>
								<p class="fadeInLeft-2 dark-color">This caption is horizontally aligned left, vertically <br>centered and it fades in left.</p>
								<div class="fadeInLeft-3">
									<a href="#" class="btn btn-large">Button</a>
								</div><!-- /.fadeIn -->
								
							</div><!-- /.caption -->
						</div><!-- /.container -->
					</div><!-- /.item -->
					
					<div class="item" style="background-image: url(assets/images/art/slider02.jpg);">
						<div class="container">
							<div class="caption vertical-center text-right">
								
								<h1 class="fadeInRight-1 light-color">Caption <br>right center</h1>
								<p class="fadeInRight-2 light-color">This caption is horizontally aligned right, vertically <br>centered and it fades in right.</p>
								<div class="fadeInRight-3">
									<a href="#" class="btn btn-large">Button</a>
								</div><!-- /.fadeIn -->
								
							</div><!-- /.caption -->
						</div><!-- /.container -->
					</div><!-- /.item -->
					
					<div class="item" style="background-image: url(assets/images/art/slider03.jpg);">
						<div class="container">
							<div class="caption vertical-top text-left">
								
								<h1 class="fadeIn-1 dark-bg light-color"><span>Caption block dark background</span></h1>
								<p class="fadeIn-2 dark-color">This block caption is horizontally aligned left, vertically top and it fades in.</p>
								<div class="fadeIn-3">
									<a href="#" class="btn btn-large">Button</a>
								</div><!-- /.fadeIn -->
								
							</div><!-- /.caption -->
						</div><!-- /.container -->
					</div><!-- /.item -->
					
					<div class="item" style="background-image: url(assets/images/art/slider04.jpg);">
						<div class="container">
							<div class="caption vertical-bottom text-right">
								
								<h1 class="fadeInUp-1 light-bg dark-color"><span>Caption Block Light Background</span></h1>
								<p class="fadeInUp-2 light-color">This block caption is horizontally aligned right, vertically bottom and it fades in up.</p>
								<div class="fadeInUp-3">
									<a href="#" class="btn btn-large">Button</a>
								</div><!-- /.fadeIn -->
								
							</div><!-- /.caption -->
						</div><!-- /.container -->
					</div><!-- /.item -->
					
				
  
  
  
  
  <?php
	
}







function sliderTriple(){
	
	
	?>
  
  
  <div id="owl-work-samples" class="owl-carousel">
								
								<div class="item">
									<a href="slider-carousel.html">
										<figure>
											<figcaption class="text-overlay">
												<div class="info">
													<h4>Astor & Yancy</h4>
													<p>Identity</p>
												</div><!-- /.info -->
											</figcaption>
											<img src="assets/images/art/work09.jpg" alt="">
										</figure>
									</a>
								</div><!-- /.item -->
								
								<div class="item">
									<a href="slider-carousel.html">
										<figure>
											<figcaption class="text-overlay">
												<div class="info">
													<h4>Signwall</h4>
													<p>Identity</p>
												</div><!-- /.info -->
											</figcaption>
											<img src="assets/images/art/work16.jpg" alt="">
										</figure>
									</a>
								</div><!-- /.item -->
								
								<div class="item">
									<a href="slider-carousel.html">
										<figure>
											<figcaption class="text-overlay">
												<div class="info">
													<h4>Tri Fold Brochure</h4>
													<p>Print</p>
												</div><!-- /.info -->
											</figcaption>
											<img src="assets/images/art/work10.jpg" alt="">
										</figure>
									</a>
								</div><!-- /.item -->
								
								<div class="item">
									<a href="slider-carousel.html">
										<figure>
											<figcaption class="text-overlay">
												<div class="info">
													<h4>Vintage Bicycles</h4>
													<p>Interactive</p>
												</div><!-- /.info -->
											</figcaption>
											<img src="assets/images/art/work03.jpg" alt="">
										</figure>
									</a>
								</div><!-- /.item -->
								
								<div class="item">
									<a href="slider-carousel.html">
										<figure>
											<figcaption class="text-overlay">
												<div class="info">
													<h4>Simpli Nota</h4>
													<p>Identity</p>
												</div><!-- /.info -->
											</figcaption>
											<img src="assets/images/art/work04.jpg" alt="">
										</figure>
									</a>
								</div><!-- /.item -->
								
								<div class="item">
									<a href="slider-carousel.html">
										<figure>
											<figcaption class="text-overlay">
												<div class="info">
													<h4>Vinyl Records</h4>
													<p>Identity</p>
												</div><!-- /.info -->
											</figcaption>
											<img src="assets/images/art/work07.jpg" alt="">
										</figure>
									</a>
								</div><!-- /.item -->
								
								<div class="item">
									<a href="slider-carousel.html">
										<figure>
											<figcaption class="text-overlay">
												<div class="info">
													<h4>Embroidered</h4>
													<p>Identity</p>
												</div><!-- /.info -->
											</figcaption>
											<img src="assets/images/art/work05a.jpg" alt="">
										</figure>
									</a>
								</div><!-- /.item -->
								
								<div class="item">
									<a href="slider-carousel.html">
										<figure>
											<figcaption class="text-overlay">
												<div class="info">
													<h4>El Corcho</h4>
													<p>Identity</p>
												</div><!-- /.info -->
											</figcaption>
											<img src="assets/images/art/work12.jpg" alt="">
										</figure>
									</a>
								</div><!-- /.item -->
								
							</div>
  
  
  <?php
	
}

}