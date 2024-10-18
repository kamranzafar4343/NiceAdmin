    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">

        <style>
            body {
                font-family: 'Times New Roman', Times, serif;
            }

            .custom-text {
                font-size: 20px;
            }
        </style>
    </head>


    <body>
        <!-- Invoice 1 - Bootstrap Brain Component -->
        <section class="py-3 py-md-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-9 col-xl-8 col-xxl-7">
                        <div class="row gy-3 mb-3">
                            <div class="col-6">
                                <h2 class="text-uppercase text-endx m-0">Invoice</h2>
                            </div>

                            <div class="col-12">
                                <h3>From</h3>
                                <address class="custom-text">
                                    875 N Coast Hwybr<br>
                                    Laguna Beach, California, 92651<br>
                                    United States<br>
                                    Phone: (949) 494-7695<br>
                                    Email: email@domain.com
                                </address>
                            </div>
                            
                        </div>
                        <div class="row mb-3" >
                            <div class="col-12 col-sm-6 col-md-8">
                                <address class="custom-text">
                                    7657 NW Prairie View Rd<br>
                                    Kansas City, Mississippi, 64151<br>
                                </address>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4">
                                <h4 class="row">
                                    <span class="col-6">Invoice #</span>
                                    <span class="col-6 text-sm-end">INT-001</span>
                                </h4>
                                <div class="row">
                                    <span class="col-6">Account</span>
                                    <span class="col-6 text-sm-end">786-54984</span>
                                    <span class="col-6">Order ID</span>
                                    <span class="col-6 text-sm-end">#9742</span>
                                    <span class="col-6">Invoice Date</span>
                                    <span class="col-6 text-sm-end">12/10/2025</span>
                                    <span class="col-6">Due Date</span>
                                    <span class="col-6 text-sm-end">18/12/2025</span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-uppercase">Qty</th>
                                                <th scope="col" class="text-uppercase">Product</th>
                                                <th scope="col" class="text-uppercase text-end">Unit Price</th>
                                                <th scope="col" class="text-uppercase text-end">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-group-divider">
                                            <tr>
                                                <th scope="row">2</th>
                                                <td>Console - Bootstrap Admin Template</td>
                                                <td class="text-end">75</td>
                                                <td class="text-end">150</td>
                                            </tr>

                                            </tr>
                                            <tr>
                                                <td colspan="3" class="text-end">Shipping</td>
                                                <td class="text-end">15</td>
                                            </tr>
                                            <tr>
                                                <th scope="row" colspan="3" class="text-uppercase text-end">Total</th>
                                                <td class="text-end">$495.1</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary mb-3">Download Invoice</button>
                                <button type="submit" class="btn btn-danger mb-3">Submit Payment</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </body>

    </html>