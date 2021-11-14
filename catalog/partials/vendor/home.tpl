<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <section class="panel">
            <div class="panel-body">
                <div class="top-stats-panel">
                    <div class="gauge-canvas">
                        <h4 class="widget-h">Contact Person</h4>
                        <img class="img-circle" src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" width="120" height="120">
                    </div>
                    <div class="col-md-12">
                        <h3 class="text-center">{{result[0][0].employee_name}}</h3>
                        <div class="text-center">{{result[0][0].email}}</div>
                        <div class="text-center">{{result[0][0].phone}}</div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="col-md-3"></div>
</div>
<div class="row">
    <div class="col-md-3">
        <a href="#products/3/0/live">
            <div class="mini-stat clearfix">
                <span class="mini-stat-icon green"><i class="fa fa-check"></i></span>
                <div class="mini-stat-info">
                    <span>{{result[2][0].total_products ? result[2][0].total_products : 0}}</span>
                    Approved
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="#products/0/0/waiting">
            <div class="mini-stat clearfix">
                <span class="mini-stat-icon yellow"><i class="fa fa-refresh"></i></span>
                <div class="mini-stat-info">
                    <span>{{(result[1][0].total_products | num) + (result[4][0].total_products | num)}}</span>
                    Waiting for Approval
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="#products/4/0/rejected">
            <div class="mini-stat clearfix">
                <span class="mini-stat-icon orange"><i class="fa fa-times"></i></span>
                <div class="mini-stat-info">
                    <span>{{result[3][0].total_products}}</span>
                    Rejected
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="#products">
            <div class="mini-stat clearfix">
                <span class="mini-stat-icon blue"><i class="fa fa-book"></i></span>
                <div class="mini-stat-info">
                    <span>
                        {{(result[1][0].total_products | num) + (result[2][0].total_products | num) + (result[3][0].total_products | num) + (result[4][0].total_products | num)}}
                    </span>
                    Total Products Uploaded
                </div>
            </div>
        </a>
    </div>
</div>