@extends('frontend.layouts.app')
@section('title', 'Deals en Route|Main')
@section('content')
<!-- Search -->
<div class="home-login-btn">
    <a href="#login" class="call-to-action button" data-toggle="modal">Login</a>
</div>
<div class="search-section">

	<div class="clouds-and-balloons">
		<div class="clouds">
	        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="420px" height="180px" viewBox="0 0 762 331" enable-background="new 0 0 762 331" xml:space="preserve" class="cloud distant smaller">
	            <path fill="#FFFFFF" d="M715.394,228h-16.595c0.79-5.219,1.201-10.562,1.201-16c0-58.542-47.458-106-106-106
	                c-8.198,0-16.178,0.932-23.841,2.693C548.279,45.434,488.199,0,417.5,0c-84.827,0-154.374,65.401-160.98,148.529
	                C245.15,143.684,232.639,141,219.5,141c-49.667,0-90.381,38.315-94.204,87H46.607C20.866,228,0,251.058,0,279.5
	                S20.866,331,46.607,331h668.787C741.133,331,762,307.942,762,279.5S741.133,228,715.394,228z"/>
	        </svg> 
	        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="420px" height="180px" viewBox="0 0 762 331" enable-background="new 0 0 762 331" xml:space="preserve" class="cloud small slow">
	            <path fill="#FFFFFF" d="M715.394,228h-16.595c0.79-5.219,1.201-10.562,1.201-16c0-58.542-47.458-106-106-106
	                c-8.198,0-16.178,0.932-23.841,2.693C548.279,45.434,488.199,0,417.5,0c-84.827,0-154.374,65.401-160.98,148.529
	                C245.15,143.684,232.639,141,219.5,141c-49.667,0-90.381,38.315-94.204,87H46.607C20.866,228,0,251.058,0,279.5
	                S20.866,331,46.607,331h668.787C741.133,331,762,307.942,762,279.5S741.133,228,715.394,228z"/>
	        </svg> 
	        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="420px" height="180px" viewBox="0 0 762 331" enable-background="new 0 0 762 331" xml:space="preserve" class="cloud slower">
	            <path fill="#FFFFFF" d="M715.394,228h-16.595c0.79-5.219,1.201-10.562,1.201-16c0-58.542-47.458-106-106-106
	                c-8.198,0-16.178,0.932-23.841,2.693C548.279,45.434,488.199,0,417.5,0c-84.827,0-154.374,65.401-160.98,148.529
	                C245.15,143.684,232.639,141,219.5,141c-49.667,0-90.381,38.315-94.204,87H46.607C20.866,228,0,251.058,0,279.5
	                S20.866,331,46.607,331h668.787C741.133,331,762,307.942,762,279.5S741.133,228,715.394,228z"/>
	        </svg>
	    </div>
	    <div class="clouds right">
	        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="420px" height="180px" viewBox="0 0 762 331" enable-background="new 0 0 762 331" xml:space="preserve" class="cloud distant smaller">
	            <path fill="#FFFFFF" d="M715.394,228h-16.595c0.79-5.219,1.201-10.562,1.201-16c0-58.542-47.458-106-106-106
	                c-8.198,0-16.178,0.932-23.841,2.693C548.279,45.434,488.199,0,417.5,0c-84.827,0-154.374,65.401-160.98,148.529
	                C245.15,143.684,232.639,141,219.5,141c-49.667,0-90.381,38.315-94.204,87H46.607C20.866,228,0,251.058,0,279.5
	                S20.866,331,46.607,331h668.787C741.133,331,762,307.942,762,279.5S741.133,228,715.394,228z"/>
	            </svg> 
	            <span class="balloon-sm"></span>
	            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="420px" height="180px" viewBox="0 0 762 331" enable-background="new 0 0 762 331" xml:space="preserve" class="cloud small slow">
	            <path fill="#FFFFFF" d="M715.394,228h-16.595c0.79-5.219,1.201-10.562,1.201-16c0-58.542-47.458-106-106-106
	                c-8.198,0-16.178,0.932-23.841,2.693C548.279,45.434,488.199,0,417.5,0c-84.827,0-154.374,65.401-160.98,148.529
	                C245.15,143.684,232.639,141,219.5,141c-49.667,0-90.381,38.315-94.204,87H46.607C20.866,228,0,251.058,0,279.5
	                S20.866,331,46.607,331h668.787C741.133,331,762,307.942,762,279.5S741.133,228,715.394,228z"/>
	            </svg> <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="420px" height="180px" viewBox="0 0 762 331" enable-background="new 0 0 762 331" xml:space="preserve" class="cloud slower">
	            <path fill="#FFFFFF" d="M715.394,228h-16.595c0.79-5.219,1.201-10.562,1.201-16c0-58.542-47.458-106-106-106
	                c-8.198,0-16.178,0.932-23.841,2.693C548.279,45.434,488.199,0,417.5,0c-84.827,0-154.374,65.401-160.98,148.529
	                C245.15,143.684,232.639,141,219.5,141c-49.667,0-90.381,38.315-94.204,87H46.607C20.866,228,0,251.058,0,279.5
	                S20.866,331,46.607,331h668.787C741.133,331,762,307.942,762,279.5S741.133,228,715.394,228z"/>
	            </svg>
	    </div>
	    <span class="balloon"></span>
	</div>
	<div class="container pt-90">
        <h1 class="index-head"> Find and Register your Deals en Route Business </h1>
        <div class="getstart-search">
            <form class="form-inline">
                <div class="row">
                    <div class="col-sm-5 col-xs-12"><div class="form-group">
                        <input type="text" class="form-control" id="inputOne" placeholder="Street Address">
                    </div></div>
                    <div class="col-sm-5 col-xs-12"><div class="form-group">
                        <input type="text" class="form-control" id="inputTwo" placeholder="Business Name">
                    </div></div>
                    <div class="col-sm-2 col-xs-12"><button type="submit" class="btn btn-default"><i class="fa fa-search"></i> Get Started</button></div>
                </div>
            </form>
        </div>

		<div class="col-xs-12 search-result-wrapper">
			<div>Showing 20 results for Papa Jhon's near Boston, MA</div>
			<table id="example" class="table search-result-list" style="width:100%">
				<thead></thead>
		        <tbody>
		            <tr>
		                <td>
							<h4 class="s-title">1. Papa Jhan's Pizza</h4>
							<span class="s-address">971 Tremont St, <br>Boston, MA 02119</span>	
		                </td>
		                <td>
		                	<a href="" class="continue-btn call-to-action button">Continue</a>
		                </td>
		            </tr>

		            <tr>
		                <td>
							<h4 class="s-title">1. Papa Jhan's Pizza</h4>
							<span class="s-address">971 Tremont St, <br>Boston, MA 02119</span>	
		                </td>
		                <td>
		                	<a href="" class="continue-btn call-to-action button">Continue</a>
		                </td>
		            </tr>

		            <tr>
		                <td>
							<h4 class="s-title">1. Papa Jhan's Pizza</h4>
							<span class="s-address">971 Tremont St, <br>Boston, MA 02119</span>	
		                </td>
		                <td>
		                	<a href="" class="continue-btn call-to-action button">Continue</a>
		                </td>
		            </tr>

		            <tr>
		                <td>
							<h4 class="s-title">1. Papa Jhan's Pizza</h4>
							<span class="s-address">971 Tremont St, <br>Boston, MA 02119</span>	
		                </td>
		                <td>
		                	<a href="" class="continue-btn call-to-action button">Continue</a>
		                </td>
		            </tr>

		            <tr>
		                <td>
							<h4 class="s-title">1. Papa Jhan's Pizza</h4>
							<span class="s-address">971 Tremont St, <br>Boston, MA 02119</span>	
		                </td>
		                <td>
		                	<a href="" class="continue-btn call-to-action button">Continue</a>
		                </td>
		            </tr>

		            <tr>
		                <td>
							<h4 class="s-title">1. Papa Jhan's Pizza</h4>
							<span class="s-address">971 Tremont St, <br>Boston, MA 02119</span>	
		                </td>
		                <td>
		                	<a href="" class="continue-btn call-to-action button">Continue</a>
		                </td>
		            </tr>

		            <tr>
		                <td>
							<h4 class="s-title">1. Papa Jhan's Pizza</h4>
							<span class="s-address">971 Tremont St, <br>Boston, MA 02119</span>	
		                </td>
		                <td>
		                	<a href="" class="continue-btn call-to-action button">Continue</a>
		                </td>
		            </tr>

		            <tr>
		                <td>
							<h4 class="s-title">1. Papa Jhan's Pizza</h4>
							<span class="s-address">971 Tremont St, <br>Boston, MA 02119</span>	
		                </td>
		                <td>
		                	<a href="" class="continue-btn call-to-action button">Continue</a>
		                </td>
		            </tr>

		            <tr>
		                <td>
							<h4 class="s-title">1. Papa Jhan's Pizza</h4>
							<span class="s-address">971 Tremont St, <br>Boston, MA 02119</span>	
		                </td>
		                <td>
		                	<a href="" class="continue-btn call-to-action button">Continue</a>
		                </td>
		            </tr>

		            <tr>
		                <td>
							<h4 class="s-title">1. Papa Jhan's Pizza</h4>
							<span class="s-address">971 Tremont St, <br>Boston, MA 02119</span>	
		                </td>
		                <td>
		                	<a href="" class="continue-btn call-to-action button">Continue</a>
		                </td>
		            </tr>

		            <tr>
		                <td>
							<h4 class="s-title">1. Papa Jhan's Pizza</h4>
							<span class="s-address">971 Tremont St, <br>Boston, MA 02119</span>	
		                </td>
		                <td>
		                	<a href="" class="continue-btn call-to-action button">Continue</a>
		                </td>
		            </tr>

		            <tr>
		                <td>
							<h4 class="s-title">1. Papa Jhan's Pizza</h4>
							<span class="s-address">971 Tremont St, <br>Boston, MA 02119</span>	
		                </td>
		                <td>
		                	<a href="" class="continue-btn call-to-action button">Continue</a>
		                </td>
		            </tr>

		            <tr>
		                <td>
							<h4 class="s-title">1. Papa Jhan's Pizza</h4>
							<span class="s-address">971 Tremont St, <br>Boston, MA 02119</span>	
		                </td>
		                <td>
		                	<a href="" class="continue-btn call-to-action button">Continue</a>
		                </td>
		            </tr>

		            <tr>
		                <td>
							<h4 class="s-title">1. Papa Jhan's Pizza</h4>
							<span class="s-address">971 Tremont St, <br>Boston, MA 02119</span>	
		                </td>
		                <td>
		                	<a href="" class="continue-btn call-to-action button">Continue</a>
		                </td>
		            </tr>

		            <tr>
		                <td>
							<h4 class="s-title">1. Papa Jhan's Pizza</h4>
							<span class="s-address">971 Tremont St, <br>Boston, MA 02119</span>	
		                </td>
		                <td>
		                	<a href="" class="continue-btn call-to-action button">Continue</a>
		                </td>
		            </tr>
		        </tbody>
		        <tfoot></tfoot>
		    </table>
		</div>
    </div>

    <div class="search-footer-bg">
    	<footer class="footer-content">
            <ul class="social">
                <li class="facebook"> <a target="_blank" href="https://www.facebook.com/dealsenroute"><i class="fa fa-facebook"></i> <span>Facebook</span> </a> </li>
                <li class="linkedin"> <a target="_blank" href="https://www.linkedin.com/company/11119147"><i class="fa fa-linkedin"></i> <span>LinkedIn</span> </a> </li>
                <li class="twitter"> <a target="_blank" href="https://twitter.com/dealsenroute"><i class="fa fa-twitter"></i> <span>Twitter</span> </a> </li>
                <li class="instagram"> <a target="_blank" href="https://www.instagram.com/dealsenroute"><i class="fa fa-instagram"></i> <span>Instagram</span> </a> </li>
            </ul>
            <div class="links">
                <ul>
                    <li class="tos"> <a target="_blank" href="http://dealsenroute.com/terms_condition">Terms and Conditions</a> </li>
                    <li class="privacy"> <a target="_blank" href="http://dealsenroute.com/privacy_policy">Privacy Policy</a> </li>
                    <li class="help"> <a target="_blank" href="http://dealsenroute.com/help">Help</a> </li>
                </ul>
            </div>
            <p class="copyright"> Copyright © <script>document.write(new Date().getFullYear())</script> <a href="#">Deals en Route</a>.  All Rights Reserved.</p>
    	</footer>
    </div>
</div>
<!-- end of search -->
@endsection


