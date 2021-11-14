<script type="text/javascript" src="rm/js/rm-quotation.js"></script>
<form class="form-horizontal">
    <div class="col-md-12 padding5" id="cusSearchBlock">
        <header class="text-center rm_heading m-bot20">Quotations</header>
        <div class="form-group">
            <label class="col-sm-3 control-label">Search a Company: </label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="scn-customer-list-select" placeholder="Please search to select company.">
            </div>
        </div>
        <div class="form-group display-none" id="selectRegionBlock">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="panel-heading">
                    Please select location you would like to quote
                </div>
                <div class="panel">
                    <div class="panel-body" id="regionSelection"></div>
                </div>
            </div>
        </div>
    </div>
</form>
<div class="row">
    <div class="col-sm-12 ">
        <div class="globalAlert">
        </div>
        <div id="create-quotation" class="display-none">
            <div class="panel-heading">
                create or update quotation
            </div>
            <div class="panel panel-head-create-quote">
                <a href="#quote-create-form" data-toggle="modal">
                    <button type="button" class="btn btn-primary col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4 col-xs-4 col-xs-offset-4" id="create-new-quotation-btn">
                        Create Quotation
                    </button>
                </a>
                <button type="button" class="btn btn-primary col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4 col-xs-4 col-xs-offset-4" onclick="updateQuote()" id="update-quotation-btn">
                    View / Update Quotation
                </button>
            </div>

        </div>
        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="quote-create-form" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                        <h3 class="modal-title text-center text-primary modal-text-font">Create Quotation</h3>
                    </div>
                    <form class="form-horizontal" role="form" onsubmit="quotationAdd(); return false;" id="newaddress">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="inputQuoteName" class="col-sm-2 control-label">
                                    Quotation Name:
                                </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputQuoteName" placeholder="Enter quotation name" required="" />
                                </div>
                                <div class="help-block fa fa-info-circle ">Invalid characters: !&lt;&gt;;?=+()@#"�{}_$%:'</div>
                            </div>
                            <button class="btn btn-primary" type="submit" id="quote-create-pop-btn">
                                Create
                            </button>
                            <button class="btn btn-primary modal-close display-none" data-dismiss="modal">
                                Close
                            </button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="search-add-prod" class="display-none">
        <div class="col-md-8">
            <div class="panel-heading col-md-12">
                <a href="#"><i class="fa fa-arrow-circle-left arrow-back-create" onclick="navigateBack(0)"></i></a> search and add products to quotation
                <div><span id="quote_name_span"></span></div>
            </div>
            <div class="col-md-12 panel">
                <div id="addProToQuotation" class="row">
                    <div class="col-xs-12 col-md-12" id="add-product-scn">
                        <form action="" onsubmit="event.preventDefault(); prodAddToCart(); return false;">
                            <div class="form-group col-xs-12 ">
                                <div class="col-xs-8">
                                    <input id="focusedInputQuotation" type="text" placeholder="Search for products from catalogue" class="form-control" required="">
                                    <div class="pro productNotFound display-none"><span>Product not found.</span></div>
                                    <div id="quotation-processing" class="display-none">
                                        Processing........
                                        <div class="progress progress-striped active progress-sm">
                                            <div aria-valuemax="100" aria-valuemin="0" aria-valuenow="45" role="progressbar" class="progress-bar progress-bar-success progress-bar-quote">
                                                <span class="sr-only">100% Complete</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <select class="populate placeholder select2-offscreen form-control regions-block-add" multiple="multiple" name="regions[]"></select>
                                </div>
                            </div>
                            <div class="col-xs-12 form-group">
                                <div class="form-group col-xs-4">
                                    <span><i class="fa fa-inr"></i></span>
                                    <input id="scn-corporate-user-quantity-value" type="text" placeholder="Price" class="form-control tex-ali-cen" required="">
                                </div>
                                <div class="form-group col-xs-2 date">
                                    <input type="text" id="scn-quote-product-date" class="form-control date_picker" placeholder="Date" class="form-control">
                                </div>
                                <div class="form-group col-xs-4" id="prod-remarks-field-1">
                                    <input type="text" id="remarksInput" autocomplete="off" placeholder="Add remarks to product" class="form-control">
                                </div>
                                <div class="form-group col-xs-2">
                                    <button type="submit" class="btn btn-primary form-control" id="quotation-corporate-user-add-to-cart">Add&nbsp;<i class="fa fa-arrow-right"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-xs-12 col-md-12 display-none" id="view-cus-prices">
                    <div class="product-status"></div>
                    <div class="col-xs-3 border1 padding5">Product code:&nbsp;&nbsp;&nbsp;<span class="productCode tex-ali-cen"></span></div>
                    <div class="col-xs-3 border1 padding5">MRP:&nbsp;&nbsp;&nbsp;<span class="mrp tex-ali-cen"></span></div>
                    <div class="col-xs-3 border1 padding5">Price in Site:&nbsp;&nbsp;&nbsp;<span class="disc_price"></span></div>
                    <div class="col-xs-3 border1 padding5">GST:&nbsp;&nbsp;&nbsp;<span class="vat tex-ali-cen"></span></div>
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>Price Suggestions</th>
                                <th>
                                    <div class="arrow-up"></div>
                                </th>
                                <th>
                                    <div class="arrow-down"></div>
                                </th>
                                <th>View Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Existing Customer Price (Tax Exclusive) 
                                    <i class="fa fa-question-circle text-primary" title="These are the prices at which our customers are buying today across the country." aria-hidden="true"></i>
                                </td>
                                <td class="high-price-cus"></td>
                                <td class="low-price-cus"></td>
                                <td>
                                    <a href="#view-exist-cus" data-toggle="modal" id="viewPriceCustomer">
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th colspan="6" class="text-center">Region Details<i class="fa fa-question-circle text-primary" title="The lowest agreed buying price from the manufacturer region wise." aria-hidden="true"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="region_name"></tr>
                            <tr class="region_price"></tr>
                            <tr class="region_availability"></tr>
                        </tbody>
                    </table>
                    <div class="text-center">
                        <div class="col-xs-12 padding5">
                            <textarea class="form-control" id="messageDescription" placeholder="Briefly explain the data errors."></textarea>
                        </div>
                        <div class="reportError padding10"></div>
                    </div>
            </div>
            <div class="clear">
            </div>
            <div class="col-xs-12 col-md-12" id="add-product-scn-revise">
                <form action="" onsubmit="event.preventDefault(); addToTableRevise(); return false;">
                    <div class="form-group col-xs-12">
                        <div class="col-xs-8">
                            <input id="focusedInputQuotationRevise" type="text" placeholder="Search for products from catalogue" class="form-control" required="">
                            <div class="pro productNotFound display-none"><span>Product not found.</span></div>
                            <div id="quotation-processing-revised" class="display-none">
                                Processing........
                                <div class="progress progress-striped active progress-sm">
                                    <div aria-valuemax="100" aria-valuemin="0" aria-valuenow="45" role="progressbar" class="progress-bar progress-bar-success progress-bar-quote">
                                        <span class="sr-only">100% Complete</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <select class="populate placeholder select2-offscreen form-control regions-block-revise" multiple="multiple" name="regions[]"></select>
                        </div>
                    </div>
                    <div class="form-group col-xs-12">
                        <div class="form-group col-xs-4">
                            <span><i class="fa fa-inr"></i></span>
                            <input id="scn-corporate-user-quantity-value-revise" type="text" placeholder="Price" class="form-control tex-ali-cen" required="">
                        </div>
                        <div class="form-group col-xs-2 date">
                            <input type="text" id="scn-revise-quote-product-date" class="form-control date_picker" placeholder="Date" class="form-control">
                        </div>
                        <div class="form-group col-xs-4 remarks-revise">
                            <input type="text" id="remarksInputRevise" autocomplete="off" placeholder="Add remarks to product" class="form-control">
                        </div>
                        <div class="form-group col-xs-2">
                            <button type="submit" class="btn btn-primary form-control" id="quotation-corporate-user-add-to-cart-revise">Add&nbsp;<i class="fa fa-arrow-right"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        </div>
    <div class="col-md-4 col-xs-12 col-sm-12">
        <div id="product-result-block" class="panel">
            <div class="panel-heading col-md-12">
                products
            </div>
            <section class="">
                <div id="productList" class="product-result-height">
                    <div class="shoppingCartTableScn col-xs-12">
                        <table class="table general-table">
                            <thead>
                                <tr>
                                    <th class="col-xs-5">
                                        Product Name
                                    </th>
                                    <th class="col-xs-3">
                                        Product Code
                                    </th>
                                    <th class="col-xs-3">
                                        Price
                                    </th>
                                    <th class="col-xs-1">
                                        Date
                                    </th>
                                    <th class="col-xs-1">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                        </table>
                        <form id="quote-save-form" onsubmit="addToQuotation(); return false;">
                            <table class="rm_shopping_cart_scn">
                                <tbody id="rm_shopping_cart_scn">
                                </tbody>
                            </table>
                        </form>
                        <button id="quote-download-btn" class="btn btn-primary col-xs-8 col-xs-offset-2" onclick="downloadQuotation();">
                            Download
                        </button>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<div id="update-quote">
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    <a href="#"><i class="fa fa-arrow-circle-left arrow-back-re-view" onclick="navigateBack(2)"></i></a> Quotation History
                </header>
                <div id="quotation-history-hidden" class="display-none">
                    <form id="form_quotation_excel" name="form_invoice" action="scn-quote-excel.php" autocomplete="off" method="post" class="display-none">
                        <div id="quotation-history-hidden-data">
                        </div>
                    </form>
                </div>
                <div class="panel-body">
                    <table class="table no-more-tables table-hover" id="quote-list">
                        <thead class="width100">
                            <tr>
                                <th>Quote ID</th>
                                <th>Quotation Name</th>
                                <th>Version</th>
                                <th>Company</th>
                                <th>Created By</th>
                                <th>Date generated</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="quotation_history">
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</div>
<div id="revise-quote">
    <div class="row">
        <div class="col-sm-12">
            <section class="panel panel-quote-revise">
                <header class="panel">
                    <div id="quotation_name_revise"></div>
                    <a href="#"><i class="fa fa-arrow-circle-left arrow-back-revise" onclick="navigateBack(1)"></i></a>
                    <div id="quote-revise-text" class="panel-heading">
                        QUOTATION REVISE
                    </div>
                    <center>
                        <div id='revise-quote-name' class="padding5"></div>
                    </center>
                    <div id="add-product-revise"></div>
                    <div class="clear"></div>
                </header>
                <div class="col-xs-12 col-md-12 display-none" id="view-cus-prices-revise">
                    <div class="product-status"></div>
                    <div class="col-xs-3 border1 padding5">Product code:&nbsp;&nbsp;&nbsp;<span class="productCode tex-ali-cen"></span></div>
                    <div class="col-xs-3 border1 padding5">MRP:&nbsp;&nbsp;&nbsp;<span class="mrp tex-ali-cen"></span></div>
                    <div class="col-xs-3 border1 padding5">Price in Site:&nbsp;&nbsp;&nbsp;<span class="disc_price"></span></div>
                    <div class="col-xs-3 border1 padding5">GST:&nbsp;&nbsp;&nbsp;<span class="vat tex-ali-cen"></span></div>
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>Price Suggestions</th>
                                <th>
                                    <div class="arrow-up"></div>
                                </th>
                                <th>
                                    <div class="arrow-down"></div>
                                </th>
                                <th>View Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Existing Customer Price (Tax Exclusive)
                                    <i class="fa fa-question-circle text-primary" title="These are the prices at which our customers are buying today across the country." aria-hidden="true"></i></td>
                                <td class="high-price-cus"></td>
                                <td class="low-price-cus"></td>
                                <td>
                                    <a href="#view-exist-cus" data-toggle="modal" id="viewPriceCustomerRevise">
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th colspan="6" class="text-center">Region Details<i class="fa fa-question-circle text-primary" title="The lowest agreed buying price from the manufacturer region wise." aria-hidden="true"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="region_name"></tr>
                            <tr class="region_price"></tr>
                            <tr class="region_availability"></tr>
                        </tbody>
                    </table>
                    <div class="text-center">
                        <div class="col-xs-12 padding5">
                            <textarea class="form-control" id="messageDescriptionRevise" placeholder="Briefly explain the data errors."></textarea>
                        </div>
                        <div class="reportError padding10"></div>
                    </div>
                </div>
            </section>
        <div class="panel" id="quotationHistoryView">
            <header>
                <div class='panel-heading'>
                    Quote Products
                </div>
            </header>
            <table class="table table-hover general-table">
                <thead class="panel">
                    <tr>
                        <th class="col-md-3">
                            Product Name
                        </th>
                        <th class="col-md-2">
                            Reference
                        </th>
                        <th class="col-md-2">
                            GST %
                        </th>
                        <th class="col-md-2">
                            Price
                        </th>
                        <th class="col-md-2">
                            Date
                        </th>
                        <th class="col-md-1">
                            Action
                        </th>
                    </tr>
                </thead>
            </table>
            <form id="quote-revise-form" onsubmit="downloadQuotation(); return false;">
                <table class="quotation_history_view">
                    <tbody id="quotation_history_view" class="panel">
                    </tbody>
                </table>
                <button class="btn-round btn btn-success cur-poi revise-btn" type="submit">
                            <i class='fa fa-edit'></i> &nbsp;&nbsp;Download
                         </button>
            </form>
        </div>
        <div class="clear">
        </div>
    </div>
</div>
<div id="dialog" class="display-none">

</div>
</div>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="viewQuoteProducts" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content viewQuoteProducts">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h3 class="modal-title text-center text-primary modal-text-font">Quotation Products</h3>
            </div>
            <div class="modal-body">
                <form action="">
                    <div class="form-group">
                        <center><div id="quoteInfoView" class="padding5"></div></center>
                        <table class="table table-hover" id="view-quote">
                            <thead>
                                <tr>
                                    <th class="col-xs-4">
                                        Product Name
                                    </th>
                                    <th class="col-xs-2">
                                        Product Code
                                    </th>
                                    <th class="col-xs-2">
                                        GST %
                                    </th>
                                    <th class="col-xs-2">
                                        Price
                                    </th>
                                    <th class="col-xs-2">
                                        Expire date
                                    </th>
                                </tr>
                            </thead>
                        </table>
                        <div class="quotation_history_view_scn">
                            <table class="table">
                                <tbody id="quotation_history_view_scn">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer modal-foot-download">
                <div id="view-block-download-div">
                    <button type="button" class="btn btn-success" id="view-block-download">
                            Download&nbsp;&nbsp;
                            <i class='fa fa-download '></i>
                        </button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal fade select-cus-group">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h3 class="modal-title text-center text-primary modal-text-font">Alert!</h3>
            </div>
            <div class="modal-body">
                <div class="display-content">
                </div>
                <button class="btn btn-primary modal-close display-none cancel-selection" data-dismiss="modal">
                        Close
                    </button>
            </div>
        </div>
    </div>
</div>

<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="view-exist-cus" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content viewQuoteProducts">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h3 class="modal-title text-center modal-text-font"> Existing Company Product's Prices.</h3>
            </div>
            <div class="modal-body">
                <form action="">
                    <div class="form-group">
                        <div class="panel-body text-center">
                            <div class="existingCustomerTable">
                                <table class="table table-bordered">
                                    <thead class="cf panel-title">
                                        <tr>
                                            <th class="col-xs-2">S.No</th>
                                            <th class="col-xs-4">Company</th>
                                            <th class="col-xs-2">Price</th>
                                            <th class="col-xs-2">Last Updated</th>
                                            <th class="col-xs-2">Valid Till</th>
                                        </tr>
                                    </thead>
                                    <tbody class="view-exist-cus">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <input type="button" name="cancel" data-dismiss="modal" class="btn btn-default" value="OK" />
            </div>
        </div>
    </div>
</div>
</div>

<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="publishQuoteConfirmation" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content viewQuoteProducts">
            <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h3 class="modal-title text-center text-primary modal-text-font">Do you want to continue?</h3>
            </div>
            <div class="modal-body">
                <form action="">
                    <div class="form-group">
                        <div class="panel-body">
                            <p>
                                Once you publish this quote, Rate Contract and Specific Price will be changed.  
                            </p>
                            <span class="rm-quote-publish-loader ajaxLoaderModal" style="display:none;">
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer quote-confirm-footer"></div>
        </div>
    </div>
</div>
</div>

<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="publishFailed" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content viewQuoteProducts">
            <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h3 class="modal-title text-center text-danger modal-text-font"> Publish Failed.</h3>
            </div>
            <div class="modal-body">
                <form action="">
                    <div class="form-group">
                        <div class="panel-body text-danger text-center">
                            <p>
                                Error found in publishing quotation.Please check your product availability in Quotation.  
                            </p>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <input type="button" name="cancel" data-dismiss="modal" class="btn btn-default" value="OK"/>
            </div>
        </div>
    </div>
</div>
</div>

<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="publish-quote-success" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content viewQuoteProducts">
            <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h3 class="modal-title text-center text-success modal-text-font" style="color:#31881b;">Quotation Published Successfully.</h3>
            </div>
            <div class="modal-body">
                <form action="">
                    <div class="form-group">
                        <div class="panel-body text-center">
                            <p class="specific-update">
                                
                            </p>
                            <p class="specific-add">
                                
                            </p>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <input type="button" name="cancel" data-dismiss="modal" class="btn btn-default" value="OK"/>
            </div>
        </div>
    </div>
</div>
</div>

<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="publish-quote-error" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content viewQuoteProducts">
            <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h3 class="modal-title text-center modal-text-font">
                        Quotation Publish Failed
                    </h3>
            </div>
            <div class="modal-body">
                <div class="panel-body" id="product-error-details">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="col-xs-1">Code</th>
                                <th class="col-xs-3">Product Name</th>
                                <th class="col-xs-1">MRP</th>
                                <th class="col-xs-1">Quoted Price</th>
                                <th class="col-xs-1">GST</th>
                                <th class="col-xs-5">Error Description</th>
                            </tr>
                        </thead>
                        <tbody id="publish-quote-error-body"></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <span class="help-text">Note: Please fix the errors and then try to publish this quotation.</span>
                <input type="button" name="cancel" data-dismiss="modal" class="btn btn-default" value="OK"/>
            </div>
        </div>
    </div>
</div>
</div>

<input type="hidden" name="regions" value="" id="regions" />