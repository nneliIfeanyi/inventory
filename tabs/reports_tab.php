<div class="tab-pane fade" id="v-pills-reports" role="tabpanel" aria-labelledby="v-pills-reports-tab">
    <div class="card card-outline-secondary my-4">
        <div class="card-header">Reports<button id="reportsTablesRefresh" name="reportsTablesRefresh" class="btn btn-warning float-right btn-sm">Refresh</button></div>
        <div class="card-body">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#itemReportsTab">Item</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#customerReportsTab">Customer</a>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#saleReportsTab">Sale</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#purchaseReportsTab">Purchase</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#vendorReportsTab">Vendor</a>
                </li> -->
            </ul>

            <!-- Tab panes for reports sections -->
            <div class="tab-content">
                <div id="itemReportsTab" class="container-fluid tab-pane active">
                    <br>
                    <p>Use the grid below to get reports for items</p>
                    <div class="table-responsive" id="itemReportsTableDiv"></div>
                </div>
                <!-- <div id="customerReportsTab" class="container-fluid tab-pane fade">
                    <br>
                    <p>Use the grid below to get reports for customers</p>
                    <div class="table-responsive" id="customerReportsTableDiv"></div>
                </div> -->
                <div id="saleReportsTab" class="container-fluid tab-pane fade">
                    <br>
                    <!-- <p>Use the grid below to get reports for sales</p> -->
                    <form>
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="saleReportStartDate">Start Date</label>
                                <input type="text" class="form-control datepicker" id="saleReportStartDate" value="2018-05-24" name="saleReportStartDate" readonly>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="saleReportEndDate">End Date</label>
                                <input type="text" class="form-control datepicker" id="saleReportEndDate" value="2018-05-24" name="saleReportEndDate" readonly>
                            </div>
                        </div>
                        <button type="button" id="showSaleReport" class="btn btn-dark">Show Report</button>
                        <button type="reset" id="saleFilterClear" class="btn">Clear</button>
                    </form>
                    <br><br>
                    <div class="table-responsive" id="saleReportsTableDiv"></div>
                </div>
                <div id="purchaseReportsTab" class="container-fluid tab-pane fade">
                    <br>
                    <!-- <p>Use the grid below to get reports for purchases</p> -->
                    <form>
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="purchaseReportStartDate">Start Date</label>
                                <input type="text" class="form-control datepicker" id="purchaseReportStartDate" value="2018-05-24" name="purchaseReportStartDate" readonly>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="purchaseReportEndDate">End Date</label>
                                <input type="text" class="form-control datepicker" id="purchaseReportEndDate" value="2018-05-24" name="purchaseReportEndDate" readonly>
                            </div>
                        </div>
                        <button type="button" id="showPurchaseReport" class="btn btn-dark">Show Report</button>
                        <button type="reset" id="purchaseFilterClear" class="btn">Clear</button>
                    </form>
                    <br><br>
                    <div class="table-responsive" id="purchaseReportsTableDiv"></div>
                </div>
                <!-- <div id="vendorReportsTab" class="container-fluid tab-pane fade">
                    <br>
                    <p>Use the grid below to get reports for vendors</p>
                    <div class="table-responsive" id="vendorReportsTableDiv"></div>
                </div> -->
            </div>
        </div>
    </div>
</div>