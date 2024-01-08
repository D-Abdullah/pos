 <?php $__env->startSection('content'); ?>
<?php if(session()->has('not_permitted')): ?>
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('not_permitted')); ?></div>
<?php endif; ?>
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4><?php echo e(trans('file.Add Purchase')); ?></h4>
                    </div>
                    <div class="card-body">
                        <p class="italic"><small><?php echo e(trans('file.The field labels marked with * are required input fields')); ?>.</small></p>
                        <?php echo Form::open(['route' => 'purchases.store', 'method' => 'post', 'files' => true, 'id' => 'purchase-form']); ?>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><?php echo e(trans('file.Date')); ?></label>
                                            <input type="text" name="created_at" class="form-control date" placeholder="Choose date"/>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><?php echo e(trans('file.Warehouse')); ?> *</label>
                                            <select required name="warehouse_id" class="selectpicker form-control" data-live-search="true" title="Select warehouse...">
                                                <?php $__currentLoopData = $lims_warehouse_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $warehouse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($warehouse->id); ?>"><?php echo e($warehouse->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><?php echo e(trans('file.Supplier')); ?></label>
                                            <select name="supplier_id" class="selectpicker form-control" data-live-search="true" title="Select supplier...">
                                                <?php $__currentLoopData = $lims_supplier_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($supplier->id); ?>"><?php echo e($supplier->name .' ('. $supplier->company_name .')'); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><?php echo e(trans('file.Purchase Status')); ?></label>
                                            <select name="status" class="form-control">
                                                <option value="1"><?php echo e(trans('file.Recieved')); ?></option>
                                                <option value="2"><?php echo e(trans('file.Partial')); ?></option>
                                                <option value="3"><?php echo e(trans('file.Pending')); ?></option>
                                                <option value="4"><?php echo e(trans('file.Ordered')); ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><?php echo e(trans('file.Attach Document')); ?></label> <i class="dripicons-question" data-toggle="tooltip" title="Only jpg, jpeg, png, gif, pdf, csv, docx, xlsx and txt file is supported"></i>
                                            <input type="file" name="document" class="form-control" >
                                            <?php if($errors->has('extension')): ?>
                                                <span>
                                                   <strong><?php echo e($errors->first('extension')); ?></strong>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label><?php echo e(trans('file.Currency')); ?> *</label>
                                            <select name="currency_id" id="currency-id" class="form-control selectpicker" data-toggle="tooltip" title="">
                                                <?php $__currentLoopData = $currency_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($currency_data->id); ?>" data-rate="<?php echo e($currency_data->exchange_rate); ?>" <?php if($currency_data->exchange_rate == 1): ?><?php echo e('checked'); ?><?php endif; ?>><?php echo e($currency_data->code); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div> 
                                    <div class="col-md-2">
                                        <div class="form-group mb-0">
                                            <label><?php echo e(trans('file.Exchange Rate')); ?> *</label>
                                        </div>
                                        <div class="form-group d-flex">
                                            <input class="form-control" type="text" id="exchange_rate" name="exchange_rate" value="<?php echo e($currency->exchange_rate); ?>">
                                            <div class="input-group-append">
                                                <span class="input-group-text" data-toggle="tooltip" title="" data-original-title="currency exchange rate">i</span>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $__currentLoopData = $custom_fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(!$field->is_admin || \Auth::user()->role_id == 1): ?>
                                            <div class="<?php echo e('col-md-'.$field->grid_value); ?>">
                                                <div class="form-group">
                                                    <label><?php echo e($field->name); ?></label>
                                                    <?php if($field->type == 'text'): ?>
                                                        <input type="text" name="<?php echo e(str_replace(' ', '_', strtolower($field->name))); ?>" value="<?php echo e($field->default_value); ?>" class="form-control" <?php if($field->is_required): ?><?php echo e('required'); ?><?php endif; ?>>
                                                    <?php elseif($field->type == 'number'): ?>
                                                        <input type="number" name="<?php echo e(str_replace(' ', '_', strtolower($field->name))); ?>" value="<?php echo e($field->default_value); ?>" class="form-control" <?php if($field->is_required): ?><?php echo e('required'); ?><?php endif; ?>>
                                                    <?php elseif($field->type == 'textarea'): ?>
                                                        <textarea rows="5" name="<?php echo e(str_replace(' ', '_', strtolower($field->name))); ?>" value="<?php echo e($field->default_value); ?>" class="form-control" <?php if($field->is_required): ?><?php echo e('required'); ?><?php endif; ?>></textarea>
                                                    <?php elseif($field->type == 'checkbox'): ?>
                                                        <br>
                                                        <?php $option_values = explode(",", $field->option_value); ?>
                                                        <?php $__currentLoopData = $option_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <label>
                                                                <input type="checkbox" name="<?php echo e(str_replace(' ', '_', strtolower($field->name))); ?>[]" value="<?php echo e($value); ?>" <?php if($value == $field->default_value): ?><?php echo e('checked'); ?><?php endif; ?> <?php if($field->is_required): ?><?php echo e('required'); ?><?php endif; ?>> <?php echo e($value); ?>

                                                            </label>
                                                            &nbsp;
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php elseif($field->type == 'radio_button'): ?>
                                                        <br>
                                                        <?php $option_values = explode(",", $field->option_value); ?>
                                                        <?php $__currentLoopData = $option_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <label class="radio-inline">
                                                                <input type="radio" name="<?php echo e(str_replace(' ', '_', strtolower($field->name))); ?>" value="<?php echo e($value); ?>" <?php if($value == $field->default_value): ?><?php echo e('checked'); ?><?php endif; ?> <?php if($field->is_required): ?><?php echo e('required'); ?><?php endif; ?>> <?php echo e($value); ?>

                                                            </label>
                                                            &nbsp;
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php elseif($field->type == 'select'): ?>
                                                        <?php $option_values = explode(",", $field->option_value); ?>
                                                        <select class="form-control" name="<?php echo e(str_replace(' ', '_', strtolower($field->name))); ?>" <?php if($field->is_required): ?><?php echo e('required'); ?><?php endif; ?>>
                                                            <?php $__currentLoopData = $option_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($value); ?>" <?php if($value == $field->default_value): ?><?php echo e('selected'); ?><?php endif; ?>><?php echo e($value); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    <?php elseif($field->type == 'multi_select'): ?>
                                                        <?php $option_values = explode(",", $field->option_value); ?>
                                                        <select class="form-control" name="<?php echo e(str_replace(' ', '_', strtolower($field->name))); ?>[]" <?php if($field->is_required): ?><?php echo e('required'); ?><?php endif; ?> multiple>
                                                            <?php $__currentLoopData = $option_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($value); ?>" <?php if($value == $field->default_value): ?><?php echo e('selected'); ?><?php endif; ?>><?php echo e($value); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    <?php elseif($field->type == 'date_picker'): ?>
                                                        <input type="text" name="<?php echo e(str_replace(' ', '_', strtolower($field->name))); ?>" value="<?php echo e($field->default_value); ?>" class="form-control date" <?php if($field->is_required): ?><?php echo e('required'); ?><?php endif; ?>>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-md-12 mt-3">
                                        <label><?php echo e(trans('file.Select Product')); ?></label>
                                        <div class="search-box input-group">
                                            <button class="btn btn-secondary"><i class="fa fa-barcode"></i></button>
                                            <input type="text" name="product_code_name" id="lims_productcodeSearch" placeholder="Please type product code and select..." class="form-control" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <h5><?php echo e(trans('file.Order Table')); ?> *</h5>
                                        <div class="table-responsive mt-3">
                                            <table id="myTable" class="table table-hover order-list">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo e(trans('file.name')); ?></th>
                                                        <th><?php echo e(trans('file.Code')); ?></th>
                                                        <th><?php echo e(trans('file.Quantity')); ?></th>
                                                        <th class="recieved-product-qty d-none"><?php echo e(trans('file.Recieved')); ?></th>
                                                        <th><?php echo e(trans('file.Batch No')); ?></th>
                                                        <th><?php echo e(trans('file.Expired Date')); ?></th>
                                                        <th><?php echo e(trans('file.Net Unit Cost')); ?></th>
                                                        <th><?php echo e(trans('file.Discount')); ?></th>
                                                        <th><?php echo e(trans('file.Tax')); ?></th>
                                                        <th><?php echo e(trans('file.Subtotal')); ?></th>
                                                        <th><i class="dripicons-trash"></i></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                                <tfoot class="tfoot active">
                                                    <th colspan="2"><?php echo e(trans('file.Total')); ?></th>
                                                    <th id="total-qty">0</th>
                                                    <th class="recieved-product-qty d-none"></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th id="total-discount"><?php echo e(number_format(0, $general_setting->decimal, '.', '')); ?></th>
                                                    <th id="total-tax"><?php echo e(number_format(0, $general_setting->decimal, '.', '')); ?></th>
                                                    <th id="total"><?php echo e(number_format(0, $general_setting->decimal, '.', '')); ?></th>
                                                    <th><i class="dripicons-trash"></i></th>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="hidden" name="total_qty" />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="hidden" name="total_discount" />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="hidden" name="total_tax" />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="hidden" name="total_cost" />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="hidden" name="item" />
                                            <input type="hidden" name="order_tax" />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="hidden" name="grand_total" />
                                            <input type="hidden" name="paid_amount" value="<?php echo e(number_format(0, $general_setting->decimal, '.', '')); ?>" />
                                            <input type="hidden" name="payment_status" value="1" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><?php echo e(trans('file.Order Tax')); ?></label>
                                            <select class="form-control" name="order_tax_rate">
                                                <option value="0"><?php echo e(trans('file.No Tax')); ?></option>
                                                <?php $__currentLoopData = $lims_tax_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($tax->rate); ?>"><?php echo e($tax->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>
                                                <strong><?php echo e(trans('file.Discount')); ?></strong>
                                            </label>
                                            <input type="number" name="order_discount" class="form-control" step="any" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>
                                                <strong><?php echo e(trans('file.Shipping Cost')); ?></strong>
                                            </label>
                                            <input type="number" name="shipping_cost" class="form-control" step="any" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label><?php echo e(trans('file.Note')); ?></label>
                                            <textarea rows="5" class="form-control" name="note"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" id="submit-btn"><?php echo e(trans('file.submit')); ?></button>
                                </div>
                            </div>
                        </div>
                        <?php echo Form::close(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <table class="table table-bordered table-condensed totals">
            <td><strong><?php echo e(trans('file.Items')); ?></strong>
                <span class="pull-right" id="item"><?php echo e(number_format(0, $general_setting->decimal, '.', '')); ?></span>
            </td>
            <td><strong><?php echo e(trans('file.Total')); ?></strong>
                <span class="pull-right" id="subtotal"><?php echo e(number_format(0, $general_setting->decimal, '.', '')); ?></span>
            </td>
            <td><strong><?php echo e(trans('file.Order Tax')); ?></strong>
                <span class="pull-right" id="order_tax"><?php echo e(number_format(0, $general_setting->decimal, '.', '')); ?></span>
            </td>
            <td><strong><?php echo e(trans('file.Order Discount')); ?></strong>
                <span class="pull-right" id="order_discount"><?php echo e(number_format(0, $general_setting->decimal, '.', '')); ?></span>
            </td>
            <td><strong><?php echo e(trans('file.Shipping Cost')); ?></strong>
                <span class="pull-right" id="shipping_cost"><?php echo e(number_format(0, $general_setting->decimal, '.', '')); ?></span>
            </td>
            <td><strong><?php echo e(trans('file.grand total')); ?></strong>
                <span class="pull-right" id="grand_total"><?php echo e(number_format(0, $general_setting->decimal, '.', '')); ?></span>
            </td>
        </table>
    </div>
    <div id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="modal-header" class="modal-title"></h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row modal-element">
                            <div class="col-md-4 form-group">
                                <label><?php echo e(trans('file.Quantity')); ?></label>
                                <input type="number" name="edit_qty" class="form-control" step="any">
                            </div>
                            <div class="col-md-4 form-group">
                                <label><?php echo e(trans('file.Unit Discount')); ?></label>
                                <input type="number" name="edit_discount" class="form-control" step="any">
                            </div>
                            <div class="col-md-4 form-group">
                                <label><?php echo e(trans('file.Unit Cost')); ?></label>
                                <input type="number" name="edit_unit_cost" class="form-control" step="any">
                            </div>
                            <?php
                                $tax_name_all[] = 'No Tax';
                                $tax_rate_all[] = 0;
                                foreach($lims_tax_list as $tax) {
                                    $tax_name_all[] = $tax->name;
                                    $tax_rate_all[] = $tax->rate;
                                }
                            ?>
                            <div class="col-md-4 form-group">
                                <label><?php echo e(trans('file.Tax Rate')); ?></label>
                                <select name="edit_tax_rate" class="form-control selectpicker">
                                    <?php $__currentLoopData = $tax_name_all; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($key); ?>"><?php echo e($name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label><?php echo e(trans('file.Product Unit')); ?></label>
                                <select name="edit_unit" class="form-control selectpicker">
                                </select>
                            </div>
                        </div>
                        <button type="button" name="update_btn" class="btn btn-primary"><?php echo e(trans('file.update')); ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">

    $("ul#purchase").siblings('a').attr('aria-expanded','true');
    $("ul#purchase").addClass("show");
    $("ul#purchase #purchase-create-menu").addClass("active");

    // array data depend on warehouse
    var product_code = [];
    var product_name = [];
    var product_qty = [];

    // array data with selection
    var product_cost = [];
    var product_discount = [];
    var tax_rate = [];
    var tax_name = [];
    var tax_method = [];
    var unit_name = [];
    var unit_operator = [];
    var unit_operation_value = [];
    var is_imei = [];

    // temporary array
    var temp_unit_name = [];
    var temp_unit_operator = [];
    var temp_unit_operation_value = [];

    var rowindex;
    var customer_group_rate;
    var row_product_cost;
    var currency = <?php echo json_encode($currency) ?>;
    var exchangeRate = 1;
    var currencyChange = false;

    $('#currency-id').val(currency['id']);
    $('.selectpicker').selectpicker({
        style: 'btn-link',
    });

    $('.selectpicker').selectpicker('refresh');

    $('#currency-id').change(function(){
        var rate = $(this).find(':selected').data('rate');
        var currency_id = $(this).val();
        $('#exchange_rate').val(rate);
        exchangeRate = rate;
        currencyChange = true;
        $("table.order-list tbody .qty").each(function(index) {
            rowindex = index;
            checkQuantity($(this).val(), true);
        });
    });

    $('[data-toggle="tooltip"]').tooltip();

    $('select[name="status"]').on('change', function() {
        if($('select[name="status"]').val() == 2){
            $(".recieved-product-qty").removeClass("d-none");
            $(".qty").each(function() {
                rowindex = $(this).closest('tr').index();
                $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.recieved').val($(this).val());
            });

        }
        else if(($('select[name="status"]').val() == 3) || ($('select[name="status"]').val() == 4)) {
            $(".recieved-product-qty").addClass("d-none");
            $(".recieved").each(function() {
                $(this).val(0);
            });
        }
        else {
            $(".recieved-product-qty").addClass("d-none");
            $(".qty").each(function() {
                rowindex = $(this).closest('tr').index();
                $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.recieved').val($(this).val());
            });
        }
    });

    <?php $productArray = []; ?>
    var lims_product_code = [
        <?php $__currentLoopData = $lims_product_list_without_variant; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $productArray[] = htmlspecialchars($product->code) . '|' . preg_replace('/[\n\r]/', "<br>", htmlspecialchars($product->name));
            ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php $__currentLoopData = $lims_product_list_with_variant; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $productArray[] = htmlspecialchars($product->item_code) . '|' . preg_replace('/[\n\r]/', "<br>", htmlspecialchars($product->name));
            ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        
        <?php
            echo  '"'.implode('","', $productArray).'"';
        ?>
    ];

    var lims_productcodeSearch = $('#lims_productcodeSearch');

    lims_productcodeSearch.autocomplete({
    source: function(request, response) {
        var matcher = new RegExp(".?" + $.ui.autocomplete.escapeRegex(request.term), "i");
        response($.grep(lims_product_code, function(item) {
            return matcher.test(item);
        }));
    },
    response: function(event, ui) {
        if (ui.content.length == 1) {
            var data = ui.content[0].value;
            $(this).autocomplete( "close" );
            productSearch(data);
        };
    },
    select: function(event, ui) {
        var data = ui.item.value;
        productSearch(data);
    }
 });

    $('body').on('focus',".expired-date", function() {
        $(this).datepicker({
            format: "yyyy-mm-dd",
            startDate: "<?php echo date("Y-m-d", strtotime('+ 1 days')) ?>",
            autoclose: true,
            todayHighlight: true
        });
    });



    //Change quantity
    $("#myTable").on('input', '.qty', function() {
        rowindex = $(this).closest('tr').index();
        if($(this).val() < 1 && $(this).val() != '') {
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val(1);
        alert("Quantity can't be less than 1");
        }
        checkQuantity($(this).val(), true);
    });


    //Delete product
    $("table.order-list tbody").on("click", ".ibtnDel", function(event) {
        rowindex = $(this).closest('tr').index();
        product_cost.splice(rowindex, 1);
        product_discount.splice(rowindex, 1);
        tax_rate.splice(rowindex, 1);
        tax_name.splice(rowindex, 1);
        tax_method.splice(rowindex, 1);
        unit_name.splice(rowindex, 1);
        unit_operator.splice(rowindex, 1);
        unit_operation_value.splice(rowindex, 1);
        console.log(product_cost);
        $(this).closest("tr").remove();
        calculateTotal();
    });

    //Edit product
    $("table.order-list").on("click", ".edit-product", function() {
    rowindex = $(this).closest('tr').index();
    $(".imei-section").remove();
    if(is_imei[rowindex]) {
        var imeiNumbers = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.imei-number').val();

        htmlText = '<div class="col-md-12 form-group imei-section"><label>IMEI or Serial Numbers</label><input type="text" name="imei_numbers" value="'+imeiNumbers+'" class="form-control imei_number" placeholder="Type imei or serial numbers and separate them by comma. Example:1001,2001" step="any"></div>';
        $("#editModal .modal-element").append(htmlText);
    }

    var row_product_name = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(1)').text();
    var row_product_code = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(2)').text();
    $('#modal-header').text(row_product_name + '(' + row_product_code + ')');

    var qty = $(this).closest('tr').find('.qty').val();
    $('input[name="edit_qty"]').val(qty);

    $('input[name="edit_discount"]').val(parseFloat(product_discount[rowindex]).toFixed(<?php echo e($general_setting->decimal); ?>));

    unitConversion();
    $('input[name="edit_unit_cost"]').val(row_product_cost.toFixed(<?php echo e($general_setting->decimal); ?>));

    var tax_name_all = <?php echo json_encode($tax_name_all) ?>;
    var pos = tax_name_all.indexOf(tax_name[rowindex]);
    $('select[name="edit_tax_rate"]').val(pos);

    temp_unit_name = (unit_name[rowindex]).split(',');
    temp_unit_name.pop();
    temp_unit_operator = (unit_operator[rowindex]).split(',');
    temp_unit_operator.pop();
    temp_unit_operation_value = (unit_operation_value[rowindex]).split(',');
    temp_unit_operation_value.pop();
    $('select[name="edit_unit"]').empty();
    $.each(temp_unit_name, function(key, value) {
        $('select[name="edit_unit"]').append('<option value="' + key + '">' + value + '</option>');
    });
    $('.selectpicker').selectpicker('refresh');
 });

    //Update product
    $('button[name="update_btn"]').on("click", function() {
        if(is_imei[rowindex]) {
            var imeiNumbers = $("#editModal input[name=imei_numbers]").val();
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.imei-number').val(imeiNumbers);
        }

        var edit_discount = $('input[name="edit_discount"]').val();
        var edit_qty = $('input[name="edit_qty"]').val();
        var edit_unit_cost = $('input[name="edit_unit_cost"]').val();
        if (parseFloat(edit_discount) > parseFloat(edit_unit_cost)) {
            alert('Invalid Discount Input!');
            return;
        }

        if(edit_qty < 1) {
            $('input[name="edit_qty"]').val(1);
            edit_qty = 1;
            alert("Quantity can't be less than 1");
        }

        var row_unit_operator = unit_operator[rowindex].slice(0, unit_operator[rowindex].indexOf(","));
        var row_unit_operation_value = unit_operation_value[rowindex].slice(0, unit_operation_value[rowindex].indexOf(","));
        row_unit_operation_value = parseFloat(row_unit_operation_value);
        var tax_rate_all = <?php echo json_encode($tax_rate_all) ?>;

        tax_rate[rowindex] = parseFloat(tax_rate_all[$('select[name="edit_tax_rate"]').val()]);
        tax_name[rowindex] = $('select[name="edit_tax_rate"] option:selected').text();

        if (row_unit_operator == '*') {
            product_cost[rowindex] = $('input[name="edit_unit_cost"]').val() / row_unit_operation_value;
        } else {
            product_cost[rowindex] = $('input[name="edit_unit_cost"]').val() * row_unit_operation_value;
        }

        product_discount[rowindex] = $('input[name="edit_discount"]').val();
        var position = $('select[name="edit_unit"]').val();
        var temp_operator = temp_unit_operator[position];
        var temp_operation_value = temp_unit_operation_value[position];
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.purchase-unit').val(temp_unit_name[position]);
        temp_unit_name.splice(position, 1);
        temp_unit_operator.splice(position, 1);
        temp_unit_operation_value.splice(position, 1);

        temp_unit_name.unshift($('select[name="edit_unit"] option:selected').text());
        temp_unit_operator.unshift(temp_operator);
        temp_unit_operation_value.unshift(temp_operation_value);

        unit_name[rowindex] = temp_unit_name.toString() + ',';
        unit_operator[rowindex] = temp_unit_operator.toString() + ',';
        unit_operation_value[rowindex] = temp_unit_operation_value.toString() + ',';
        checkQuantity(edit_qty, false);
    });

    function productSearch(data) {
        $.ajax({
            type: 'GET',
            url: 'lims_product_search',
            data: {
                data: data
            },
            success: function(data) {
                var flag = 1;
                $(".product-code").each(function(i) {
                    if ($(this).val() == data[1]) {
                        rowindex = i;
                        var qty = parseFloat($('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val()) + 1;
                        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val(qty);
                        if($('select[name="status"]').val() == 1 || $('select[name="status"]').val() == 1) {
                            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .recieved').val(qty);
                        }
                        calculateRowProductData(qty);
                        flag = 0;
                    }
                });
                $("input[name='product_code_name']").val('');
                if(flag){
                    var newRow = $("<tr>");
                    var cols = '';
                    temp_unit_name = (data[6]).split(',');
                    cols += '<td>' + data[0] + '<button type="button" class="edit-product btn btn-link" data-toggle="modal" data-target="#editModal"> <i class="dripicons-document-edit"></i></button></td>';
                    cols += '<td>' + data[1] + '</td>';
                    cols += '<td><input type="number" class="form-control qty" name="qty[]" value="1" step="any" required/></td>';
                    if($('select[name="status"]').val() == 1)
                        cols += '<td class="recieved-product-qty d-none"><input type="number" class="form-control recieved" name="recieved[]" value="1" step="any"/></td>';
                    else if($('select[name="status"]').val() == 2)
                        cols += '<td class="recieved-product-qty"><input type="number" class="form-control recieved" name="recieved[]" value="1" step="any"/></td>';
                    else
                        cols += '<td class="recieved-product-qty d-none"><input type="number" class="form-control recieved" name="recieved[]" value="0" step="any"/></td>';
                    if(data[10]) {
                        cols += '<td><input type="text" class="form-control batch-no" name="batch_no[]" required/></td>';
                        cols += '<td><input type="text" class="form-control expired-date" name="expired_date[]" required/></td>';
                    }
                    else {
                        cols += '<td><input type="text" class="form-control batch-no" name="batch_no[]" disabled/></td>';
                        cols += '<td><input type="text" class="form-control expired-date" name="expired_date[]" disabled/></td>';
                    }

                    cols += '<td class="net_unit_cost"></td>';
                    cols += '<td class="discount"><?php echo e(number_format(0, $general_setting->decimal, '.', '')); ?></td>';
                    cols += '<td class="tax"></td>';
                    cols += '<td class="sub-total"></td>';
                    cols += '<td><button type="button" class="ibtnDel btn btn-md btn-danger"><?php echo e(trans("file.delete")); ?></button></td>';
                    cols += '<input type="hidden" class="product-code" name="product_code[]" value="' + data[1] + '"/>';
                    cols += '<input type="hidden" class="product-id" name="product_id[]" value="' + data[9] + '"/>';
                    cols += '<input type="hidden" class="purchase-unit" name="purchase_unit[]" value="' + temp_unit_name[0] + '"/>';
                    cols += '<input type="hidden" class="net_unit_cost" name="net_unit_cost[]" />';
                    cols += '<input type="hidden" class="discount-value" name="discount[]" />';
                    cols += '<input type="hidden" class="tax-rate" name="tax_rate[]" value="' + data[3] + '"/>';
                    cols += '<input type="hidden" class="tax-value" name="tax[]" />';
                    cols += '<input type="hidden" class="subtotal-value" name="subtotal[]" />';
                    cols += '<input type="hidden" class="imei-number" name="imei_number[]" />';
                    cols += '<input type="hidden" class="original-cost" value="'+data[2]+'" />';

                    newRow.append(cols);
                    $("table.order-list tbody").prepend(newRow);

                    rowindex = newRow.index();
                    product_cost.splice(rowindex,0, parseFloat(data[2]));
                    product_discount.splice(rowindex,0, '<?php echo e(number_format(0, $general_setting->decimal, '.', '')); ?>');
                    tax_rate.splice(rowindex,0, parseFloat(data[3]));
                    tax_name.splice(rowindex,0, data[4]);
                    tax_method.splice(rowindex,0, data[5]);
                    unit_name.splice(rowindex,0, data[6]);
                    unit_operator.splice(rowindex,0, data[7]);
                    unit_operation_value.splice(rowindex,0, data[8]);
                    is_imei.splice(rowindex, 0, data[11]);
                    checkQuantity(1, true);
                    if(data[11]) {
                        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.edit-product').click();
                    }
                }
            }
        });
    }

    function checkQuantity(purchase_qty, flag) {
        $('#editModal').modal('hide');
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.qty').val(purchase_qty);
        var status = $('select[name="status"]').val();
        if(status == '1' || status == '2' )
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.recieved').val(purchase_qty);
        else
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.recieved').val(0);
        if(flag)
            product_cost[rowindex] = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.original-cost').val() * exchangeRate;
        calculateRowProductData(purchase_qty);
    }

    function calculateRowProductData(quantity) {
        //product_cost[rowindex] = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.original-cost').val() * exchangeRate;
        unitConversion();
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.discount').text((product_discount[rowindex] * quantity).toFixed(<?php echo e($general_setting->decimal); ?>));
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.discount-value').val((product_discount[rowindex] * quantity).toFixed(<?php echo e($general_setting->decimal); ?>));
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.tax-rate').val(tax_rate[rowindex].toFixed(<?php echo e($general_setting->decimal); ?>));

        if (tax_method[rowindex] == 1) {
            var net_unit_cost = row_product_cost - product_discount[rowindex];
            var tax = net_unit_cost * quantity * (tax_rate[rowindex] / 100);
            var sub_total = (net_unit_cost * quantity) + tax;

            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.net_unit_cost').text(net_unit_cost.toFixed(<?php echo e($general_setting->decimal); ?>));
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.net_unit_cost').val(net_unit_cost.toFixed(<?php echo e($general_setting->decimal); ?>));
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.tax').text(tax.toFixed(<?php echo e($general_setting->decimal); ?>));
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.tax-value').val(tax.toFixed(<?php echo e($general_setting->decimal); ?>));
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.sub-total').text(sub_total.toFixed(<?php echo e($general_setting->decimal); ?>));
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.subtotal-value').val(sub_total.toFixed(<?php echo e($general_setting->decimal); ?>));
        } else {
            var sub_total_unit = row_product_cost - product_discount[rowindex];
            var net_unit_cost = (100 / (100 + tax_rate[rowindex])) * sub_total_unit;
            var tax = (sub_total_unit - net_unit_cost) * quantity;
            var sub_total = sub_total_unit * quantity;

            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.net_unit_cost').text(net_unit_cost.toFixed(<?php echo e($general_setting->decimal); ?>));
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.net_unit_cost').val(net_unit_cost.toFixed(<?php echo e($general_setting->decimal); ?>));
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.tax').text(tax.toFixed(<?php echo e($general_setting->decimal); ?>));
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.tax-value').val(tax.toFixed(<?php echo e($general_setting->decimal); ?>));
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.sub-total').text(sub_total.toFixed(<?php echo e($general_setting->decimal); ?>));
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.subtotal-value').val(sub_total.toFixed(<?php echo e($general_setting->decimal); ?>));
        }

        calculateTotal();
    }

    function unitConversion() {
        var row_unit_operator = unit_operator[rowindex].slice(0, unit_operator[rowindex].indexOf(","));
        var row_unit_operation_value = unit_operation_value[rowindex].slice(0, unit_operation_value[rowindex].indexOf(","));
        row_unit_operation_value = parseFloat(row_unit_operation_value);
        if (row_unit_operator == '*') {
            row_product_cost = product_cost[rowindex] * row_unit_operation_value;
        } else {
            row_product_cost = product_cost[rowindex] / row_unit_operation_value;
        }
    }

    function calculateTotal() {
        //Sum of quantity
        var total_qty = 0;
        $(".qty").each(function() {

            if ($(this).val() == '') {
                total_qty += 0;
            } else {
                total_qty += parseFloat($(this).val());
            }
        });
        $("#total-qty").text(total_qty);
        $('input[name="total_qty"]').val(total_qty);

        //Sum of discount
        var total_discount = 0;
        $(".discount").each(function() {
            total_discount += parseFloat($(this).text());
        });
        $("#total-discount").text(total_discount.toFixed(<?php echo e($general_setting->decimal); ?>));
        $('input[name="total_discount"]').val(total_discount.toFixed(<?php echo e($general_setting->decimal); ?>));

        //Sum of tax
        var total_tax = 0;
        $(".tax").each(function() {
            total_tax += parseFloat($(this).text());
        });
        $("#total-tax").text(total_tax.toFixed(<?php echo e($general_setting->decimal); ?>));
        $('input[name="total_tax"]').val(total_tax.toFixed(<?php echo e($general_setting->decimal); ?>));

        //Sum of subtotal
        var total = 0;
        $(".sub-total").each(function() {
            total += parseFloat($(this).text());
        });
        $("#total").text(total.toFixed(<?php echo e($general_setting->decimal); ?>));
        $('input[name="total_cost"]').val(total.toFixed(<?php echo e($general_setting->decimal); ?>));

        calculateGrandTotal();
    }

    function calculateGrandTotal() {
        var item = $('table.order-list tbody tr:last').index();
        var total_qty = parseFloat($('#total-qty').text());
        var subtotal = parseFloat($('#total').text());
        var order_tax = parseFloat($('select[name="order_tax_rate"]').val());
        if($('input[name="order_discount"]').val()) {
            if(!currencyChange)
                var order_discount = parseFloat($('input[name="order_discount"]').val());
            else
                var order_discount = parseFloat($('input[name="order_discount"]').val()) * exchangeRate;
        }
        else
            var order_discount = <?php echo e(number_format(0, $general_setting->decimal, '.', '')); ?>;

        if($('input[name="shipping_cost"]').val()) {
            if(!currencyChange)
                var shipping_cost = parseFloat($('input[name="shipping_cost"]').val());
            else
                var shipping_cost = parseFloat($('input[name="shipping_cost"]').val()) * exchangeRate;
        }
        else
            var shipping_cost = <?php echo e(number_format(0, $general_setting->decimal, '.', '')); ?>;

        item = ++item + '(' + total_qty + ')';
        order_tax = (subtotal - order_discount) * (order_tax / 100);
        var grand_total = (subtotal + order_tax + shipping_cost) - order_discount;

        $('#item').text(item);
        $('input[name="item"]').val($('table.order-list tbody tr:last').index() + 1);
        $('#subtotal').text(subtotal.toFixed(<?php echo e($general_setting->decimal); ?>));
        $('#order_tax').text(order_tax.toFixed(<?php echo e($general_setting->decimal); ?>));
        $('input[name="order_tax"]').val(order_tax.toFixed(<?php echo e($general_setting->decimal); ?>));
        $('#order_discount').text(order_discount.toFixed(<?php echo e($general_setting->decimal); ?>));
        $('input[name="order_discount"]').val(order_discount);
        $('#shipping_cost').text(shipping_cost.toFixed(<?php echo e($general_setting->decimal); ?>));
        $('input[name="shipping_cost"]').val(shipping_cost);
        $('#grand_total').text(grand_total.toFixed(<?php echo e($general_setting->decimal); ?>));
        $('input[name="grand_total"]').val(grand_total.toFixed(<?php echo e($general_setting->decimal); ?>));
        currencyChange = false;
    }

    $('input[name="order_discount"]').on("input", function() {
        calculateGrandTotal();
    });

    $('input[name="shipping_cost"]').on("input", function() {
        calculateGrandTotal();
    });

    $('select[name="order_tax_rate"]').on("change", function() {
        calculateGrandTotal();
    });

    $(window).keydown(function(e){
        if (e.which == 13) {
            var $targ = $(e.target);
            if (!$targ.is("textarea") && !$targ.is(":button,:submit")) {
                var focusNext = false;
                $(this).find(":input:visible:not([disabled],[readonly]), a").each(function(){
                    if (this === e.target) {
                        focusNext = true;
                    }
                    else if (focusNext){
                        $(this).focus();
                        return false;
                    }
                });
                return false;
            }
        }
    });

    $('#purchase-form').on('submit',function(e){
    var rownumber = $('table.order-list tbody tr:last').index();
    if (rownumber < 0) {
        alert("Please insert product to order table!")
        e.preventDefault();
    }

    else if($('select[name="status"]').val() != 1)
    {
        flag = 0;
        $(".qty").each(function() {
            rowindex = $(this).closest('tr').index();
            quantity =  $(this).val();
            recieved = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.recieved').val();

            if(quantity != recieved){
                flag = 1;
                return false;
            }
        });
        if(!flag){
            alert('Quantity and Recieved value is same! Please Change Purchase Status or Recieved value');
            e.preventDefault();
        }
        else
            $(".batch-no, .expired-date").prop('disabled', false);
    }
    else {
        $(".batch-no, .expired-date").prop('disabled', false);
        $("#submit-btn").prop('disabled', true);
    }
 });
</script>

<script type="text/javascript" src="https://js.stripe.com/v3/"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('backend.layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/abdullah/Downloads/POS/SalePro/resources/views/backend/purchase/create.blade.php ENDPATH**/ ?>