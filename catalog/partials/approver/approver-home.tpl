<div class="row">
  <div class="col-md-4">
    <div class="col-md-12">
        <header class="panel-heading">
            Uploaded Products By Vendors
        </header>
    </div>
    <div class="col-md-12">
        <a href="#products/1/0/waiting">
            <div class="mini-stat clearfix">
                <span class="mini-stat-icon yellow"><i class="fa fa-refresh"></i></span>
                <div class="mini-stat-info">
                    <span>{{result[0] ? (result[0] | num) : 0}}</span>
                    Waiting for your Approval
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-12">
        <a href="#products/2/0/approved">
            <div class="mini-stat clearfix">
                <span class="mini-stat-icon green"><i class="fa fa-check"></i></span>
                <div class="mini-stat-info">
                    <span>{{result[1] ? (result[1] | num) : 0}}</span>
                    Sent for QC Approval
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-12">
        <a href="#products/4/0/rejected">
            <div class="mini-stat clearfix">
                <span class="mini-stat-icon orange"><i class="fa fa-times"></i></span>
                <div class="mini-stat-info">
                    <span>{{result[3] ? (result[3] | num) : 0}}</span>
                    Rejected
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-12">
        <a href="#products/3/0/live">
            <div class="mini-stat clearfix">
                <span class="mini-stat-icon blue"><i class="fa fa-book"></i></span>
                <div class="mini-stat-info">
                    <span>{{result[2] ? (result[2] | num) : 0}}</span>
                    Products In Live
                </div>
            </div>
        </a>
    </div>
    </div>
    <div class="col-md-4">
    <div class="col-md-12">
        <header class="panel-heading">
           Products Uploaded By You
        </header>
    </div>
    <div class="col-md-12">
        <a href="#products/2/1/approved">
            <div class="mini-stat clearfix">
                <span class="mini-stat-icon green"><i class="fa fa-check"></i></span>
                <div class="mini-stat-info">
                    <span>{{result[4] ? (result[4] | num) : 0}}</span>
                    Sent for QC Approval
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-12">
        <a href="#products/4/1/rejected">
            <div class="mini-stat clearfix">
                <span class="mini-stat-icon orange"><i class="fa fa-times"></i></span>
                <div class="mini-stat-info">
                    <span>{{result[6] ? (result[6] | num) : 0}}</span>
                    Rejected
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-12">
        <a href="#products/3/1/live">
            <div class="mini-stat clearfix">
                <span class="mini-stat-icon blue"><i class="fa fa-book"></i></span>
                <div class="mini-stat-info">
                    <span>{{result[5] ? (result[5] | num) : 0}}</span>
                    Products In Live
                </div>
            </div>
        </a>
    </div>
    </div>
</div>