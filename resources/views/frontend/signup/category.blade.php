@extends('frontend.layouts.login')
@section('title', 'Deals en Route|Category')
@section('content')

<div class="home-login-btn">
    <a href="#login" class="call-to-action button" data-toggle="modal">Login</a>
</div>
<div class="search-section signup-page">
    <a href="#"><img src="public/frontend/img/logo.png" alt="" class="logo"></a>
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
        
        
        <div class="signup-form-wrapper">


                <form method="POST" action="http://dealsenroute.com/admin/users" accept-charset="UTF-8" class="form" id="signupform" enctype="multipart/form-data"><input name="_token" type="hidden" value="onrlBTBsm8WExhcNTbty0WKACptGUJSfi9M5td1x">
                <input type="hidden" name="_token" value="onrlBTBsm8WExhcNTbty0WKACptGUJSfi9M5td1x">
                <input type="hidden" name="full_address" id="full_address">
                <input type="hidden" name="vendor_long">
                <div class="poplog">
                    <div class="popupbg">
                        <a href="#"><img src="public/frontend/img/logo2.png" alt="" class="signup-logo"></a>
                        <img src="public/frontend/img/IPhoneX.png" alt="" class="iphonex">
                        <a href="#"><img src="public/frontend/img/app-store-logo.png" alt="" class="app-store-logo"></a>
                    </div>

                    <div class="signupDEtails">

                        <div class="errorpopup">
                            <div class="alert alert-success alert-dismissible" role="alert" style="display: none">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                <div class="successmessage"> </div>
                            </div>  
                            <div class="alert alert-danger alert-dismissible" role="alert" style="display: none">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                <div class="errormessage"> </div>
                            </div>  


                        </div>
                        <div class="col-sm-6">

                            <h4>Sign Up Details</h4>
                            <div class="form-group">
                                <select class="form-control selectinput" id="vendorcategory" name="vendor_category"><option value="">Select Category</option><option value="1">Restaurant</option><option value="2">Pharmacy</option><option value="3">Coffee &amp; Tea</option><option value="4">Bars</option><option value="5">Beer, Wine &amp; Liquor</option><option value="6">Apparel</option><option value="7">Shopping</option><option value="8">Nightlife</option><option value="9">Sandwich</option><option value="10">Salons &amp; Spas</option><option value="11">Theatre</option><option value="12">School Store</option><option value="13">Music</option><option value="14">Hotel</option><option value="15">Barber Shop</option><option value="16">Photography</option><option value="17">Grocery Store</option><option value="18">Juice Bar</option><option value="19">Children's Store</option><option value="20">Tattoos</option><option value="21">Jewelry Store</option><option value="22">Men's Apparel</option><option value="23">Women's Apparel</option><option value="24">Smoke Shop</option><option value="25">Pastry Shop</option><option value="26">Candy</option><option value="27">Ice Cream Shop</option><option value="28">Food Truck</option><option value="29">Outdoors</option><option value="30">Automotives</option><option value="31">Movies</option><option value="32" selected="selected">Farmers Market</option></select>
                                <!--                                <select class="form-control selectinput" id="vendorcategory" name="vendor_category"><option value="">Select Category</option><option value="other">Other</option><option value="1">Restaurant</option><option value="2">Pharmacy</option><option value="3">Coffee &amp; Tea</option><option value="4">Bars</option><option value="5">Beer, Wine &amp; Liquor</option><option value="6">Apparel</option><option value="7">Shopping</option><option value="8">Nightlife</option><option value="9">Sandwich</option><option value="10">Salons &amp; Spas</option><option value="11">Theatre</option><option value="12">School Store</option><option value="13">Music</option><option value="14">Hotel</option><option value="15">Barber Shop</option><option value="16">Photography</option><option value="17">Grocery Store</option><option value="18">Juice Bar</option><option value="19">Children&#039;s Store</option><option value="20">Tattoos</option><option value="21">Jewelry Store</option><option value="22">Men&#039;s Apparel</option><option value="23">Women&#039;s Apparel</option><option value="24">Smoke Shop</option><option value="25">Pastry Shop</option><option value="26">Candy</option><option value="27">Ice Cream Shop</option><option value="28">Food Truck</option><option value="29">Outdoors</option><option value="30">Automotives</option><option value="31">Movies</option><option value="32" selected="selected">Farmers Market</option></select>
                                <input placeholder="Category Name" class="form-control hide" name="vendor_category" type="text" value="">-->
                                <input name="browser" class="inputtext" style="display:none;" disabled="disabled">
                            </div>

                            <div class="form-group">
                                <input placeholder="Business Name" class="form-control" name="vendor_name" type="text" value="">
                            </div>


                            <div class="form-group">

                                <input placeholder="Street Address" class="form-control" id="autocomplete1" name="vendor_address" type="text" value="" autocomplete="off">
                            </div>

                            <div class="form-group">
                                <select class="form-control selectinput" id="country" name="vendor_country"><option value="" selected="selected">Select Country</option><option value="1">Afghanistan</option><option value="2">Albania</option><option value="3">Algeria</option><option value="4">American Samoa</option><option value="5">Andorra</option><option value="6">Angola</option><option value="7">Anguilla</option><option value="8">Antarctica</option><option value="9">Antigua and Barbuda</option><option value="10">Argentina</option><option value="11">Armenia</option><option value="12">Aruba</option><option value="13">Australia</option><option value="14">Austria</option><option value="15">Azerbaijan</option><option value="16">Bahamas</option><option value="17">Bahrain</option><option value="18">Bangladesh</option><option value="19">Barbados</option><option value="20">Belarus</option><option value="21">Belgium</option><option value="22">Belize</option><option value="23">Benin</option><option value="24">Bermuda</option><option value="25">Bhutan</option><option value="26">Bolivia</option><option value="27">Bosnia and Herzegovina</option><option value="28">Botswana</option><option value="29">Bouvet Island</option><option value="30">Brazil</option><option value="31">British Indian Ocean Territory</option><option value="32">Brunei Darussalam</option><option value="33">Bulgaria</option><option value="34">Burkina Faso</option><option value="35">Burundi</option><option value="36">Cambodia</option><option value="37">Cameroon</option><option value="38">Canada</option><option value="39">Cape Verde</option><option value="40">Cayman Islands</option><option value="41">Central African Republic</option><option value="42">Chad</option><option value="43">Chile</option><option value="44">China</option><option value="45">Christmas Island</option><option value="46">Cocos (Keeling) Islands</option><option value="47">Colombia</option><option value="48">Comoros</option><option value="49">Congo</option><option value="50">Cook Islands</option><option value="51">Costa Rica</option><option value="52">Croatia (Hrvatska)</option><option value="53">Cuba</option><option value="54">Cyprus</option><option value="55">Czech Republic</option><option value="56">Denmark</option><option value="57">Djibouti</option><option value="58">Dominica</option><option value="59">Dominican Republic</option><option value="60">East Timor</option><option value="61">Ecuador</option><option value="62">Egypt</option><option value="63">El Salvador</option><option value="64">Equatorial Guinea</option><option value="65">Eritrea</option><option value="66">Estonia</option><option value="67">Ethiopia</option><option value="68">Falkland Islands (Malvinas)</option><option value="69">Faroe Islands</option><option value="70">Fiji</option><option value="71">Finland</option><option value="72">France</option><option value="73">France, Metropolitan</option><option value="74">French Guiana</option><option value="75">French Polynesia</option><option value="76">French Southern Territories</option><option value="77">Gabon</option><option value="78">Gambia</option><option value="79">Georgia</option><option value="80">Germany</option><option value="81">Ghana</option><option value="82">Gibraltar</option><option value="83">Guernsey</option><option value="84">Greece</option><option value="85">Greenland</option><option value="86">Grenada</option><option value="87">Guadeloupe</option><option value="88">Guam</option><option value="89">Guatemala</option><option value="90">Guinea</option><option value="91">Guinea-Bissau</option><option value="92">Guyana</option><option value="93">Haiti</option><option value="94">Heard and Mc Donald Islands</option><option value="95">Honduras</option><option value="96">Hong Kong</option><option value="97">Hungary</option><option value="98">Iceland</option><option value="99">India</option><option value="100">Isle of Man</option><option value="101">Indonesia</option><option value="102">Iran (Islamic Republic of)</option><option value="103">Iraq</option><option value="104">Ireland</option><option value="105">Israel</option><option value="106">Italy</option><option value="107">Ivory Coast</option><option value="108">Jersey</option><option value="109">Jamaica</option><option value="110">Japan</option><option value="111">Jordan</option><option value="112">Kazakhstan</option><option value="113">Kenya</option><option value="114">Kiribati</option><option value="115">Korea, Democratic People's Republic of</option><option value="116">Korea, Republic of</option><option value="117">Kosovo</option><option value="118">Kuwait</option><option value="119">Kyrgyzstan</option><option value="120">Lao People's Democratic Republic</option><option value="121">Latvia</option><option value="122">Lebanon</option><option value="123">Lesotho</option><option value="124">Liberia</option><option value="125">Libyan Arab Jamahiriya</option><option value="126">Liechtenstein</option><option value="127">Lithuania</option><option value="128">Luxembourg</option><option value="129">Macau</option><option value="130">Macedonia</option><option value="131">Madagascar</option><option value="132">Malawi</option><option value="133">Malaysia</option><option value="134">Maldives</option><option value="135">Mali</option><option value="136">Malta</option><option value="137">Marshall Islands</option><option value="138">Martinique</option><option value="139">Mauritania</option><option value="140">Mauritius</option><option value="141">Mayotte</option><option value="142">Mexico</option><option value="143">Micronesia, Federated States of</option><option value="144">Moldova, Republic of</option><option value="145">Monaco</option><option value="146">Mongolia</option><option value="147">Montenegro</option><option value="148">Montserrat</option><option value="149">Morocco</option><option value="150">Mozambique</option><option value="151">Myanmar</option><option value="152">Namibia</option><option value="153">Nauru</option><option value="154">Nepal</option><option value="155">Netherlands</option><option value="156">Netherlands Antilles</option><option value="157">New Caledonia</option><option value="158">New Zealand</option><option value="159">Nicaragua</option><option value="160">Niger</option><option value="161">Nigeria</option><option value="162">Niue</option><option value="163">Norfolk Island</option><option value="164">Northern Mariana Islands</option><option value="165">Norway</option><option value="166">Oman</option><option value="167">Pakistan</option><option value="168">Palau</option><option value="169">Palestine</option><option value="170">Panama</option><option value="171">Papua New Guinea</option><option value="172">Paraguay</option><option value="173">Peru</option><option value="174">Philippines</option><option value="175">Pitcairn</option><option value="176">Poland</option><option value="177">Portugal</option><option value="178">Puerto Rico</option><option value="179">Qatar</option><option value="180">Reunion</option><option value="181">Romania</option><option value="182">Russian Federation</option><option value="183">Rwanda</option><option value="184">Saint Kitts and Nevis</option><option value="185">Saint Lucia</option><option value="186">Saint Vincent and the Grenadines</option><option value="187">Samoa</option><option value="188">San Marino</option><option value="189">Sao Tome and Principe</option><option value="190">Saudi Arabia</option><option value="191">Senegal</option><option value="192">Serbia</option><option value="193">Seychelles</option><option value="194">Sierra Leone</option><option value="195">Singapore</option><option value="196">Slovakia</option><option value="197">Slovenia</option><option value="198">Solomon Islands</option><option value="199">Somalia</option><option value="200">South Africa</option><option value="201">South Georgia South Sandwich Islands</option><option value="202">Spain</option><option value="203">Sri Lanka</option><option value="204">St. Helena</option><option value="205">St. Pierre and Miquelon</option><option value="206">Sudan</option><option value="207">Suriname</option><option value="208">Svalbard and Jan Mayen Islands</option><option value="209">Swaziland</option><option value="210">Sweden</option><option value="211">Switzerland</option><option value="212">Syrian Arab Republic</option><option value="213">Taiwan</option><option value="214">Tajikistan</option><option value="215">Tanzania, United Republic of</option><option value="216">Thailand</option><option value="217">Togo</option><option value="218">Tokelau</option><option value="219">Tonga</option><option value="220">Trinidad and Tobago</option><option value="221">Tunisia</option><option value="222">Turkey</option><option value="223">Turkmenistan</option><option value="224">Turks and Caicos Islands</option><option value="225">Tuvalu</option><option value="226">Uganda</option><option value="227">Ukraine</option><option value="228">United Arab Emirates</option><option value="229">United Kingdom</option><option value="230">United States</option><option value="231">United States minor outlying islands</option><option value="232">Uruguay</option><option value="233">Uzbekistan</option><option value="234">Vanuatu</option><option value="235">Vatican City State</option><option value="236">Venezuela</option><option value="237">Vietnam</option><option value="238">Virgin Islands (British)</option><option value="239">Virgin Islands (U.S.)</option><option value="240">Wallis and Futuna Islands</option><option value="241">Western Sahara</option><option value="242">Yemen</option><option value="243">Zaire</option><option value="244">Zambia</option><option value="245">Zimbabwe</option></select>
                            </div>

                            <div class="form-group">
                                <input placeholder="City" class="form-control" id="locality" name="vendor_city" type="text" value="">

                            </div>

                            <div class="form-group">
                                <input placeholder="State" class="form-control" id="administrative_area_level_1" name="vendor_state" type="text" value="">

                            </div>

                            <div class="form-group">
                                <input placeholder="Zip" maxlength="10" class="form-control" id="postal_code" name="vendor_zip" type="text" value="">

                            </div>

                            <div class="form-group">
                                <input placeholder="Phone (xxx-xxx-xxxx)" data-mask="999-999-9999" maxlength="11" class="form-control" name="vendor_phone" type="text">      
                            </div>

                            <div class="form-group">
                                <input placeholder="Email" class="form-control" name="email" type="text" value="">

                            </div>
                            <div class="form-group">
                                <input placeholder="Password" class="form-control" name="password" type="password" value="">

                            </div>
                            <div class="form-group">
                                <input placeholder="Confirm Password" class="form-control" name="confirm_password" type="password" value="">
                            </div>
                            <div class="form-group vendorlogo">
                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                    <div class="form-control" data-trigger="fileinput"><span class="fileinput-filename"></span></div>
                                    <span class="input-group-addon btn btn-default btn-file">
                                        <span class="fileinput-new">Browse</span>
                                        <span class="fileinput-exists">Change</span> 
                                        <input type="hidden"><input id="vendorlogo" accept="image/*" name="vendor_logo" type="file">
                                    </span>
                                </div>

                            </div>

                        </div>
                        <div class="col-sm-6">
                            <h4>Credit/Debit Card Info</h4>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <span class="type"></span>
                                    </span>
                                    <input class="cardNumber type" placeholder="Card Number" name="card_no">


                                </div>
                            </div>
                            <div class="form-group">
                                <input placeholder="Card Holder Name" class="form-control" name="card_holder_name" type="text" value="">

                            </div>
                            <div class="form-group">
                                    <!-- <input type="text" name="" placeholder="Expiration Date MM/YY" required> -->
                                <input placeholder="MM/YY" class="expiry form-control" name="card_expiry" type="text" value="">

                            </div>
                            <div class="form-group">
                                    <!-- <input type="number" name="" placeholder="CVV" required> -->
                                <input placeholder="CVV" class="form-control cardCvv" maxlength="4" name="card_cvv" type="text" value="">

                            </div>
                            <h4>Billing Details <span><input id="check-address" name="check-address" type="checkbox" value="yes">(Same As Business Address)</span></h4>
                            <div id="billingdetails">

                                <div class="form-group">
                                    <input placeholder="Business Name" class="form-control" name="billing_businessname" type="text" value="">

                                </div>

                                <div class="form-group">
                                    <input placeholder="Street Address" class="form-control" name="billing_home" type="text" value="">

                                </div>
                                <div class="form-group">
                                    <input placeholder="City" class="form-control" name="billing_city" type="text" value="">

                                </div>
                                <div class="form-group">
                                    <input placeholder="State" class="form-control" name="billing_state" type="text" value="">

                                </div>

                                <div class="form-group">
                                    <input placeholder="Zip" maxlength="10" class="form-control" name="billing_zip" type="text" value="">

                                </div>
                                <div class="form-group">
                                    <select class="form-control selectinput" name="billing_country"><option value="" selected="selected">Select Country</option><option value="1">Afghanistan</option><option value="2">Albania</option><option value="3">Algeria</option><option value="4">American Samoa</option><option value="5">Andorra</option><option value="6">Angola</option><option value="7">Anguilla</option><option value="8">Antarctica</option><option value="9">Antigua and Barbuda</option><option value="10">Argentina</option><option value="11">Armenia</option><option value="12">Aruba</option><option value="13">Australia</option><option value="14">Austria</option><option value="15">Azerbaijan</option><option value="16">Bahamas</option><option value="17">Bahrain</option><option value="18">Bangladesh</option><option value="19">Barbados</option><option value="20">Belarus</option><option value="21">Belgium</option><option value="22">Belize</option><option value="23">Benin</option><option value="24">Bermuda</option><option value="25">Bhutan</option><option value="26">Bolivia</option><option value="27">Bosnia and Herzegovina</option><option value="28">Botswana</option><option value="29">Bouvet Island</option><option value="30">Brazil</option><option value="31">British Indian Ocean Territory</option><option value="32">Brunei Darussalam</option><option value="33">Bulgaria</option><option value="34">Burkina Faso</option><option value="35">Burundi</option><option value="36">Cambodia</option><option value="37">Cameroon</option><option value="38">Canada</option><option value="39">Cape Verde</option><option value="40">Cayman Islands</option><option value="41">Central African Republic</option><option value="42">Chad</option><option value="43">Chile</option><option value="44">China</option><option value="45">Christmas Island</option><option value="46">Cocos (Keeling) Islands</option><option value="47">Colombia</option><option value="48">Comoros</option><option value="49">Congo</option><option value="50">Cook Islands</option><option value="51">Costa Rica</option><option value="52">Croatia (Hrvatska)</option><option value="53">Cuba</option><option value="54">Cyprus</option><option value="55">Czech Republic</option><option value="56">Denmark</option><option value="57">Djibouti</option><option value="58">Dominica</option><option value="59">Dominican Republic</option><option value="60">East Timor</option><option value="61">Ecuador</option><option value="62">Egypt</option><option value="63">El Salvador</option><option value="64">Equatorial Guinea</option><option value="65">Eritrea</option><option value="66">Estonia</option><option value="67">Ethiopia</option><option value="68">Falkland Islands (Malvinas)</option><option value="69">Faroe Islands</option><option value="70">Fiji</option><option value="71">Finland</option><option value="72">France</option><option value="73">France, Metropolitan</option><option value="74">French Guiana</option><option value="75">French Polynesia</option><option value="76">French Southern Territories</option><option value="77">Gabon</option><option value="78">Gambia</option><option value="79">Georgia</option><option value="80">Germany</option><option value="81">Ghana</option><option value="82">Gibraltar</option><option value="83">Guernsey</option><option value="84">Greece</option><option value="85">Greenland</option><option value="86">Grenada</option><option value="87">Guadeloupe</option><option value="88">Guam</option><option value="89">Guatemala</option><option value="90">Guinea</option><option value="91">Guinea-Bissau</option><option value="92">Guyana</option><option value="93">Haiti</option><option value="94">Heard and Mc Donald Islands</option><option value="95">Honduras</option><option value="96">Hong Kong</option><option value="97">Hungary</option><option value="98">Iceland</option><option value="99">India</option><option value="100">Isle of Man</option><option value="101">Indonesia</option><option value="102">Iran (Islamic Republic of)</option><option value="103">Iraq</option><option value="104">Ireland</option><option value="105">Israel</option><option value="106">Italy</option><option value="107">Ivory Coast</option><option value="108">Jersey</option><option value="109">Jamaica</option><option value="110">Japan</option><option value="111">Jordan</option><option value="112">Kazakhstan</option><option value="113">Kenya</option><option value="114">Kiribati</option><option value="115">Korea, Democratic People's Republic of</option><option value="116">Korea, Republic of</option><option value="117">Kosovo</option><option value="118">Kuwait</option><option value="119">Kyrgyzstan</option><option value="120">Lao People's Democratic Republic</option><option value="121">Latvia</option><option value="122">Lebanon</option><option value="123">Lesotho</option><option value="124">Liberia</option><option value="125">Libyan Arab Jamahiriya</option><option value="126">Liechtenstein</option><option value="127">Lithuania</option><option value="128">Luxembourg</option><option value="129">Macau</option><option value="130">Macedonia</option><option value="131">Madagascar</option><option value="132">Malawi</option><option value="133">Malaysia</option><option value="134">Maldives</option><option value="135">Mali</option><option value="136">Malta</option><option value="137">Marshall Islands</option><option value="138">Martinique</option><option value="139">Mauritania</option><option value="140">Mauritius</option><option value="141">Mayotte</option><option value="142">Mexico</option><option value="143">Micronesia, Federated States of</option><option value="144">Moldova, Republic of</option><option value="145">Monaco</option><option value="146">Mongolia</option><option value="147">Montenegro</option><option value="148">Montserrat</option><option value="149">Morocco</option><option value="150">Mozambique</option><option value="151">Myanmar</option><option value="152">Namibia</option><option value="153">Nauru</option><option value="154">Nepal</option><option value="155">Netherlands</option><option value="156">Netherlands Antilles</option><option value="157">New Caledonia</option><option value="158">New Zealand</option><option value="159">Nicaragua</option><option value="160">Niger</option><option value="161">Nigeria</option><option value="162">Niue</option><option value="163">Norfolk Island</option><option value="164">Northern Mariana Islands</option><option value="165">Norway</option><option value="166">Oman</option><option value="167">Pakistan</option><option value="168">Palau</option><option value="169">Palestine</option><option value="170">Panama</option><option value="171">Papua New Guinea</option><option value="172">Paraguay</option><option value="173">Peru</option><option value="174">Philippines</option><option value="175">Pitcairn</option><option value="176">Poland</option><option value="177">Portugal</option><option value="178">Puerto Rico</option><option value="179">Qatar</option><option value="180">Reunion</option><option value="181">Romania</option><option value="182">Russian Federation</option><option value="183">Rwanda</option><option value="184">Saint Kitts and Nevis</option><option value="185">Saint Lucia</option><option value="186">Saint Vincent and the Grenadines</option><option value="187">Samoa</option><option value="188">San Marino</option><option value="189">Sao Tome and Principe</option><option value="190">Saudi Arabia</option><option value="191">Senegal</option><option value="192">Serbia</option><option value="193">Seychelles</option><option value="194">Sierra Leone</option><option value="195">Singapore</option><option value="196">Slovakia</option><option value="197">Slovenia</option><option value="198">Solomon Islands</option><option value="199">Somalia</option><option value="200">South Africa</option><option value="201">South Georgia South Sandwich Islands</option><option value="202">Spain</option><option value="203">Sri Lanka</option><option value="204">St. Helena</option><option value="205">St. Pierre and Miquelon</option><option value="206">Sudan</option><option value="207">Suriname</option><option value="208">Svalbard and Jan Mayen Islands</option><option value="209">Swaziland</option><option value="210">Sweden</option><option value="211">Switzerland</option><option value="212">Syrian Arab Republic</option><option value="213">Taiwan</option><option value="214">Tajikistan</option><option value="215">Tanzania, United Republic of</option><option value="216">Thailand</option><option value="217">Togo</option><option value="218">Tokelau</option><option value="219">Tonga</option><option value="220">Trinidad and Tobago</option><option value="221">Tunisia</option><option value="222">Turkey</option><option value="223">Turkmenistan</option><option value="224">Turks and Caicos Islands</option><option value="225">Tuvalu</option><option value="226">Uganda</option><option value="227">Ukraine</option><option value="228">United Arab Emirates</option><option value="229">United Kingdom</option><option value="230">United States</option><option value="231">United States minor outlying islands</option><option value="232">Uruguay</option><option value="233">Uzbekistan</option><option value="234">Vanuatu</option><option value="235">Vatican City State</option><option value="236">Venezuela</option><option value="237">Vietnam</option><option value="238">Virgin Islands (British)</option><option value="239">Virgin Islands (U.S.)</option><option value="240">Wallis and Futuna Islands</option><option value="241">Western Sahara</option><option value="242">Yemen</option><option value="243">Zaire</option><option value="244">Zambia</option><option value="245">Zimbabwe</option></select>
                                </div>
                            </div>     
                        </div>
                        <div class="col-sm-12">
                            <h5>Congratulations! One more step to pushing your business to new heights! You have a 30-day free trial — Way less than what you spend on a current advertising methods collectively!</h5>
                        </div>
                        <div class="col-sm-6">
                            <input name="agree" type="checkbox" value="no">
                            I agree with <a href="#">Terms and Conditions</a>
                        </div>
                        <div class="col-sm-6">

                            <button type="submit" class="btn btn-priamry call-to-action">Sign Up</button>
                        </div>
                    </div>
                </div>
                </form>
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


@endsection
@section('scripts')
<script src="{{ asset('frontend/js/webjs/register.js?reload=1318923150"') }}"></script>
<!-- Google Maps -->
<script src="https://maps.googleapis.com/maps/api/js?key={{ \Config::get('googlemaps.key') }}&libraries=places&callback=initAutocomplete"
async defer></script>


@endsection
