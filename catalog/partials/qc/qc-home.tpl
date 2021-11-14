<div class="row">
    <div class="col-md-4">
        <a href="#products/2/waiting">
            <div class="mini-stat clearfix">
                <span class="mini-stat-icon yellow"><i class="fa fa-refresh"></i></span>
                <div class="mini-stat-info">
                    <span>{{result[1][0].total_products ? (result[1][0].total_products | num) : 0}}</span>
                    Waiting for your Approval
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="#products/4/rejected">
            <div class="mini-stat clearfix">
                <span class="mini-stat-icon orange"><i class="fa fa-times"></i></span>
                <div class="mini-stat-info">
                    <span>{{result[3][0].total_products ? (result[3][0].total_products | num) : 0}}</span>
                    Rejected
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="#products/3/live">
            <div class="mini-stat clearfix">
                <span class="mini-stat-icon blue"><i class="fa fa-book"></i></span>
                <div class="mini-stat-info">
                    <span>{{result[2][0].total_products ? (result[2][0].total_products | num) : 0}}</span>
                    Products In Live
                </div>
            </div>
        </a>
    </div>
</div>