<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th style="width:10%;"><?php echo lang('sku'); ?></th>
                    <th style="width:30%;"><?php echo lang('name'); ?></th>
                    <th style="width:10%;"><?php echo lang('price'); ?></th>
                    <!--<th><?php echo lang('description'); ?></th>-->
                    <th style="width:10%;"><?php echo lang('quantity'); ?></th>
                    <th style="width:10%; text-align: right"><?php echo lang('totals'); ?></th>
                </tr>
            </thead>

                <tfoot>
                    <?php
                    /*     * ************************************************************
                      Subtotal Calculations
                     * ************************************************************ */
                    ?>
                    <?php if ($this->go_cart->group_discount() > 0) : ?> 
                        <tr>
                            <td colspan="4"><strong><?php echo lang('group_discount'); ?></strong></td>
                            <td><?php echo format_currency(0 - $this->go_cart->group_discount()); ?></td>
                        </tr>
                    <?php endif; ?>
                    <tr>
                        <td colspan="4"><strong><?php echo lang('subtotal'); ?></strong></td>
                        <td id="gc_subtotal_price" style="text-align:right"><?php echo format_currency($this->go_cart->subtotal()); ?></td>
                    </tr>
                    <?php
                    $charges = $this->go_cart->get_custom_charges();
                    if (!empty($charges)) {
                        foreach ($charges as $name => $price) :
                            ?>

                            <tr>
                                <td colspan="4"><strong><?php echo $name ?></strong></td>
                                <td style="text-align:right"><?php echo format_currency($price); ?></td>
                            </tr>	

                        <?php
                        endforeach;
                    }

                 ?>
             
                <?php
                /* * ************************************************************
                  Grand Total
                 * ************************************************************ */
                ?>
                    <tr>
                        <td colspan="4"><strong><?php echo lang('grand_total'); ?></strong></td>
                        <td style="text-align:right"><?php echo format_currency($this->go_cart->total() + $delivery_charge); ?></td>
                    </tr>
                </tfoot>

                <tbody>
                <?php
                $subtotal = 0;

                foreach ($this->go_cart->contents() as $cartkey => $product):
					$stocks = getStock($product['stock_id']);
                ?>
                    <tr>
                        <td><?php echo $product['sku']; ?></td>
                        <td><?php echo $product['name']; ?></td>
                        <td><?php echo format_currency($product['price']); ?><?php echo (empty($product['unit'])) ? '' : '/' . $product['unit']; ?></td>
                        <td style="white-space:nowrap">
                        <?php if ($this->uri->segment(1) == 'cart'): ?>
                            <?php if ($stocks > 0): ?>
                        <div class="control-group">
						<div class="controls">
                            <div class="input-append">
                            <select class="txtbx-80 " name="cartkey[<?php echo $cartkey; ?>]" onchange="this.form.submit()">
							<?php
								
								for ($x = 1; $x <= $stocks; $x ++): ?>
									<option <?php echo ($product['quantity'] == $x) ? 'selected' : ''; ?>><?php echo $x; ?></option>
							<?php endfor; ?>
							</select>
							<button class="btn btn-danger btn-xs" type="button" onclick="if (confirm('<?php echo lang('remove_item'); ?>')) {
								window.location = '<?php echo site_url('cart/remove_item/' . $cartkey); ?>';
									}"> <i class="glyphicon glyphicon-remove"></i></button>
                                        </div>
                                    </div>
                                </div>
                            <?php else: ?>
                                    <?php echo $product['quantity'] ?>
                                    <input type="hidden" name="cartkey[<?php echo $cartkey; ?>]" value="1"/>
                                    <button class="btn btn-info" type="button" onclick="if (confirm('<?php echo lang('remove_item'); ?>')) {
                                                                                                    window.location = '<?php echo site_url('cart/remove_item/' . $cartkey); ?>';
                                                                                                }"><!-- <i class="icon-remove icon-white"></i> --> X</button>
                            <?php endif; ?>
                        <?php else: ?>
                            <?php 
                            $aa[0] = '';
                            if ($product['quantity'] == 0.25)
                            {
                                $aa[0] = '';
                                $fraction = '   1/4';
                            }
                            elseif ($product['quantity'] == 0.5)
                            {
                                $aa[0] = '';
                                $fraction = '   1/2';
                            }
                            elseif ($product['quantity'] == 0.75)
                            {
                                $aa[0] = '';
                                $fraction = '  3/4';
                            }
                            else
                            {
                                $aa = explode('.', $product['quantity']);
                                if ($aa[1] == 25)
                                {
                                    $fraction = '  1/4';
                                }
                                elseif ($aa[1] == 5)
                                {
                                    $fraction = '  1/2';
                                }
                                elseif ($aa[1] == 75)
                                {
                                    $fraction = '  3/4';
                                }
                            }
//                              echo $product['quantity'];
                            ?>
                            <?php echo (strpos($product['quantity'], ".") !== false) ? $aa[0] . $fraction : $product['quantity']; ?>
                        <?php endif; ?>
                        </td>
                        <td style="text-align: right"><?php echo format_currency($product['price'] * $product['quantity']); ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                </table>
            </div>
    </div>
</div>           