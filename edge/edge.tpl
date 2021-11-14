
<section id="container">
 
<div id="header" class="edgehead" >
	<div id="headLeft">
        <span class="marginrightleft5" id="phoneNumber"> 044-6454 3222 </span>
        <span class="marginrightleft5" id="website"> info@kobster.com</span>
    </div>
    <div id="headRight">
         <span class="marginrightleft5" id="contactus"><a href="#">Contact Us</a></span>
         <span class="marginrightleft5" id="term"><a href="#">Terms & Conditions</a></span>
         <span class="marginrightleft5" id="aboutus"><a href="#">AboutUs</a></span>
         <span class="marginrightleft5" id="newsletter"><a href="#">NewsLetter</a></span>
     </div>
 </div>
 	<section id="main-content">
    	
    	 <section class="wrapper">
         	 <section class="">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="col-xs-2"></div>
                        <div class="col-xs-8 col-sm-6 col-lg-5 col-md-5">
                            <div class="wdgt-row">
                                <img src="img/edge.png" />
                                <div class="col-xs-11">
                                    <p class="text-muted"><strong>The most efficient way to shop!</strong></p></div>
                            </div>
                        </div>
                    </div>
                </div>
          </section>
           		<!--Search the product-->
                <div class="row" id="searchProduct">
                    <div class="col-xs-2"></div>
                    <div class="col-xs-9 col-sm-5 col-md-5 col-lg-5">
                    	 <p class="errorSearch error" id="errorWord">Well, that dosen't look like a product to me! </p>
                        <input type="text" class="form-control form-group" value="" placeholder="What do you want to Buy?" name="searchProductvalue" id="searchProductvalue" />
                         <button onclick="searchPro();" class="btn btn-info btn-lg btn-block " type="button">Search</button>
                     </div>
                </div>
                <!--Search With Pincode -->
                <div class="row" id="searchPincode">
                 <div class="row">
                	<div class="col-xs-2"></div>
                    <div class="col-xs-9 col-sm-7 col-md-5 col-lg-8">
                        <p class="successSearch text-muted" >There are more than <strong><span id="countSeller">2500</span></strong> seller for this product. Please gives us your pincode to narrow it down.</p>
                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-2"></div>
                        <div class="col-xs-9 col-sm-5 col-md-5 col-lg-5">
                             <input type="text" class="form-control form-group successSearch" value="" placeholder="Pincode" name="pincode" id="pincode" />
                            <span id="errorpincode" class="error"></span>
                            <button onclick="filterPincode();" class="btn btn-info btn-lg btn-block " type="button">Filter</button>
                        </div>
                    </div>
                </div>
                <!--Get Personal Details-->
                <div class="row" id="personaldetail">
                    <div class="col-xs-2"></div>
                    <div class="col-xs-9 col-sm-5 col-md-5 col-lg-5">
                         <p class="text-muted">We can get price from over <strong><span id="filtersellers">50</span></strong> sellers for this product in <strong><span id="duration">2 hours</span></strong>.<br/> Give us the details so that we can give you the quotes.</p>
                           	<div class="form-group col-xs-6">
                                 <input type="text" placeholder="Name" name="name" id="name" class="form-control">
                                 <span class="error" id="errorname"></span>
                            </div>
                            <div class="form-group col-xs-6">
                                 <input type="text" placeholder="Mobile" name="phone" id="phone" class="form-control">
                                 <span class="error" id="errorphone"></span>
                            </div>
                            <div class="form-group col-xs-12">
                                 <input type="email" class="form-control form-group successSearch" value="" placeholder="Email" name="email" id="email" />
                                 <span class="error " id="erroremail"></span>
                             </div>
                             <div class="form-group col-xs-12">
                        		 <button onclick="savePersonalDetails();" class="btn btn-info btn-lg btn-block " type="submit">Next</button>
                             </div>
                       </div>
                </div>
                <div class="row" id="optionalFields">
                    <div class="col-xs-2"></div>
                    <div class="col-xs-9 col-sm-5 col-md-5 col-lg-5">
                         <p class="text-muted">Thank You. <br /> For an accurate quote, Fill in these optional fields</p>
                        
                        
                        <div class="form-group ">
                       		<label class="control-label col-md-4">Photo :</label>
                        	<input type="file" placeholder="Name" id="photo" >
                        </div>
                        <div class="form-group col-xs-6">
                        	<input type="text" placeholder="Quantity" id="quantity" name="quantity" class="form-control">
                        </div>
                        <div class="form-group col-xs-12">
                        	<textarea rows="1" class="form-control" placeholder="Description" id="description" name="description"></textarea>
                        <!--<input type="text" class="form-control form-group successSearch" value="" placeholder="Email" name="pincode" id="pincode" />-->
                        </div>
                         <button onclick="saveOptional();" class="btn btn-info btn-lg btn-block " type="button">Done</button>
                     </div>
                </div> 
                 <div class="row" id="thankyou">
                    <div class="col-xs-2"></div>
                    <div class="col-xs-9 col-sm-5 col-md-5 col-lg-5">
                         <p class="text-muted"><strong>Thank You! You will get the quotes soon!</strong> </p>
                        
                         <button onclick="thankYou();" class="btn btn-info btn-lg btn-block " type="button">Start Again</button>
                     </div>
                </div> 
             </section>
             <section class="top15">
                 <div class="row">
                    <div class="col-xs-4"></div>
                        <div class="col-xs-5">
                            <p class="text-muted">How does this work?</p> 
                        </div>
                 </div>
                 <div class="row marginleft50">
                     	
                        <span class="col-xs-1"> 
                                <span class="wdgt-row1">
                                    <img src="dash/images/tell-us.png" />
                                  </span>
                       </span>
                       <span class="col-xs-1"> 
                                <span class="wdgt-row1">
                                     <img src="dash/images/arrow.png" />
                                     
                                 </span>
                       </span>
                       <span class="col-xs-1"> 
                                <span class="wdgt-row1">
                                    <img src="dash/images/best_vendor.png" />
                                   </span>
                       </span>
                       <span class="col-xs-1"> 
                                <span class="wdgt-row1">
                                     <img src="dash/images/arrow.png" />
                                 </span>
                       </span>
                       <span class="col-xs-1"> 
                                <span class="wdgt-row1">
                                     <img src="dash/images/screen_icn.png" />
                                  </span>
                       </span>
                       <span class="col-xs-1"> 
                                <span class="wdgt-row1">
                                     <img src="dash/images/arrow.png" />
                                 </span>
                       </span>
                        <span class="col-xs-1"> 
                                <span class="wdgt-row1">
                                     <img src="dash/images/compare.png" />
                                  </span>
                                 
                       </span>
                      <span class="col-xs-1"> 
                                <span class="wdgt-row1">
                                     <img src="dash/images/arrow.png" />
                                 </span>
                       </span>
                        <span class="col-xs-1"> 
                                <span class="wdgt-row1">
                                     <img src="dash/images/Deal_done.png" />
                                  </span>
                       </span>
                   </div> 
                   <div class="row marginleft50">
                     	<!--<span class="col-xs-1"></span>-->
                        <span class="col-xs-2"> 
                                <span class="wdgt-row1">
                                     <div class="wdt-bottom col-xs-12">Tell us what you need?</div>
                                 </span>
                       </span>
                       
                       <span class="col-xs-2"> 
                                <span class="wdgt-row1">
                                     <div class="wdt-bottom col-xs-12">Sellers quotes for your products </div>
                                  </span>
                       </span>
                      
                       <span class="col-xs-2"> 
                                <span class="wdgt-row1">
                                      <div class="wdt-bottom col-xs-12">We screen the Quatations</div>
                                 </span>
                       </span>
                         <span class="col-xs-2"> 
                                <span class="wdgt-row1">
                                      <div class="wdt-bottom col-xs-12">You compare and select the best quote</div>
                                 </span>
                                 
                       </span>
                         <span class="col-xs-2"> 
                                <span class="wdgt-row1">
                                      <div class="wdt-bottom col-xs-12">Deal is done!</div>
                                 </span>
                       </span>
                   </div>             
                </div>
               </section> 
              <section class="edgeFooter" >
             	
                    <div class="col-xs-2">
                        <div class="panel panel-danger panel-square panel-no-border text-center  text-danger ">
                            <div class="panel-heading padding5 col-xs-12 orange">
                            	<h6 class="panel-title col-xs-12 titleFont">Active Sellers</h6>
                            </div>
                            <div class="panel-body padding3">
                                <h4 class="bolded tiles-number text-danger">5,485</h4>
                             </div> 
                        </div> 
                    </div>
                     <div class="col-xs-2">
                        <div class="panel panel-danger panel-square panel-no-border text-center  text-danger ">
                            <div class="panel-heading padding5 col-xs-12 pink">
                            	<h6 class="panel-title  titleFont">Active Buyer</h6>
                            </div>
                            <div class="panel-body padding3">
                                <h4 class="bolded tiles-number text-info">6,684</h4>
                             </div> 
                        </div> 
                    </div>
                     <div class="col-xs-2">
                        <div class="panel panel-danger panel-square panel-no-border text-center  text-danger ">
                            <div class="panel-heading padding5  yellow col-xs-12">
                            	<h6 class="panel-title  titleFont ">Active Quotes</h6>
                            </div>
                            <div class="panel-body padding3">
                                <h4 class="bolded tiles-number text-warning">8,738</h4>
                             </div> 
                        </div> 
                    </div>
                     <div class="col-xs-2">
                        <div class="panel panel-danger panel-square panel-no-border text-center  text-danger ">
                            <div class="panel-heading padding5 blue col-xs-12">
                            	<h6 class="panel-title col-xs-12 titleFont">Products</h6>
                            </div>
                            <div class="panel-body padding3">
                                <h4 class="bolded tiles-number blueFont">10,565</h4>
                             </div> 
                        </div> 
                    </div>
                     <div class="col-xs-2">
                        <div class="panel panel-danger panel-square panel-no-border text-center  text-danger ">
                            <div class="panel-heading padding5 col-xs-12 blue-info">
                            	<h6 class="panel-title col-xs-12 titleFont ">Deals</h6>
                            </div>
                            <div class="panel-body padding3">
                                <h4 class="bolded tiles-number blue-info-text">6,340</h4>
                             </div> 
                        </div> 
                    </div>
                    <div class="row">
                    	<div class="col-xs-4"></div>
                        <div class="col-xs-5" id="copyRight">
                        	<p class="text-muted ">&#169; Copyrights 2014 Kobster.com </p>
                        </div>
                    </div>
             </section>
    	</section>
   
 </section>
 <style>
 body
 {
	 background:#FFF !important;
  }
 .wrapper
 {
	 margin-top:4% !important;
 }
 
 </style>
 <script type="text/javascript" src="edge/js/typo/typo.js"></script>
 <script type="text/javascript" src="edge/js/edge.js"></script>
 