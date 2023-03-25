<?php
require_once 'pdf_format/autoload.inc.php';
	use Dompdf\Dompdf;
	$dompdf = new Dompdf();
	$name= time();
	$invoice_num = 10;
	$invoice_date = $due_date = date("d F Y");
	$sub_total_amount = "USD".(10);
	$credit_amount = "USD".(10);
	$total_amount = "USD".(10);


	$user_address = '<p style="font-size: 19px;color: #000;text-decoration:none;">Boniface Mustisya</p>
                                <p style="font-size: 19px;color: #000;text-decoration:none;">2500 State highway</p>
                                <p style="font-size: 19px;color: #000;text-decoration:none;">United States</p>
                                <p style="font-size: 19px;color: #000;text-decoration:none;">+919814327915</p>';


     $vehicle_detail = '<p style="font-size: 19px;color: #000;text-decoration:none;"><strong>Vehicle Name</strong><span>:Yangu</span></p>
                                <p style="font-size: 19px;color: #000;text-decoration:none;"><strong>Vehicle Brand</strong><span>:TOYOTO</span></p>
                                <p style="font-size: 19px;color: #000;text-decoration:none;"><strong>Vehicle Color</strong><span>:Grey</span></p>
                                <p style="font-size: 19px;color: #000;text-decoration:none;"><strong>Vehicle Type</strong><span>:Coupe,<br>compact or sedan</span></p>
                                <p style="font-size: 19px;color: #000;text-decoration:none;"><strong>Vehicle License Plate Number</strong><span>:Kcv774u</span></p>';
	
	$main_service = '<td width="20" style="border: 1px solid #eeeeee; padding: 10px 0; text-align: center;"> Basic Wash</td>
                                            <td width="20" style="border: 1px solid #eeeeee; text-align: center;">1hrs</td>
                                            <td width="20" style="border: 1px solid #eeeeee; text-align: center;">USD12.00</td>';


     $added_service = '<table border="0" cellspacing="0" cellpadding="0" style="padding: 12px 6px;width:100%" class="table table-striped table-bordered table-responsive dataTable no-footer">
                                    <thead>
                                        <tr style="background-color: #ccc;">
                                            <th width="20" style="border: 1px solid #eeeeee; padding: 10px 0; text-align: center;">Add On Services</th>
                                            <th width="20" style="border: 1px solid #eeeeee;">Duration</th>
                                            <th width="20" style="border: 1px solid #eeeeee;">Cost</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td width="20" style="border: 1px solid #eeeeee; padding: 10px 0;text-align: center;">Headlight Restoration </td>
                                            <td width="20" style="border: 1px solid #eeeeee; text-align: center;">1hrs</td>
                                            <td width="20" style="border: 1px solid #eeeeee; text-align: center;">USD12.00</td>

                                        </tr>
                                        <tr>
                                            <td width="20" style="border: 1px solid #eeeeee; padding: 10px 0; text-align: center;">Engine Wash </td>
                                            <td width="20" style="border: 1px solid #eeeeee; text-align: center;">1hrs</td>
                                            <td width="20" style="border: 1px solid #eeeeee; text-align: center;">USD12.00</td>

                                        </tr>
                                    </tbody>
                                </table>';
                                



	$put_data = '<div style="background:#fff;border: 10px solid #ccc;">
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td width="20" align="left" valign="top">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="20" align="left" valign="top">&nbsp;</td>
                        <td align="left" valign="top">
                            <a href="#" style="border:0; outline:0;">
                                <img src="assets/logo.png" alt="" width="120" style="margin-top:3px;" /></a>
                        </td>
                        <td width="20" align="left" valign="top">
                            <img src="assets/paid.png" alt="" width="120" />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td width="20" align="left" valign="top">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="20" align="left" valign="top">&nbsp;</td>
                        <td align="right" valign="top" style="padding:0;">
                            <p style="font-size: 19px;color: #01cdfe;text-decoration:none;margin:2px;">Presha wash</p>
                            <p style="font-size: 19px;color: #01cdfe;text-decoration:none;margin:2px">0708420165</p>
                            <p style="font-size: 19px;color: #01cdfe;text-decoration:none;margin:2px">pw.co.ke</p>
                        </td>
                        <td width="20" align="left" valign="top">&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td width="20" align="left" valign="top">
                <table width="auto" border="0" cellspacing="0" cellpadding="0" style="background-color: #74BF4C; color: #fff; padding: 12px 9px;width:100%">
                    <tr>
                        <td align="left" valign="top" width="200">
                            <h2 style="font-size: 24px; color: #fff; text-decoration:none; margin:0;">Invoice #'.$invoice_num.'</h2></td>
                        <td align="left" valign="top" style="padding:10px 0; ">

                        </td>
                    </tr>
                    <tr>
                        <td width="100" style="">
                            <label>Invoice Date:</label>
                        </td>
                        <td>
                            <p style="font-size: 19px;color: #fff;text-decoration:none;  margin: 0;">'.$invoice_date.'</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="">
                            <label>Due Date:</label>
                        </td>

                        <td>
                            <p style="font-size: 19px;color: #fff;text-decoration:none; margin: 0;">'.$due_date.'</p>
                        </td>
                        <td width="20" align="left" valign="top">&nbsp;</td>
                </table>
            </td>
            </tr>
            <tr>
                <td width="20" align="right" valign="top">
                    <table style="width:100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="20" align="right" valign="top">&nbsp;</td>
                            <td align="left" valign="top" style="padding:10px 0;">
                                <h2 style="font-size: 19px;color: #01cdfe;text-decoration:none;">Invoice To</h2>
                                	'.$user_address.'
                                
                            </td>
                            <td align="left" valign="top" style="padding:10px 0;">
                                <h2 style="font-size: 19px;color: #01cdfe;text-decoration:none;">Vehicle details</h2>
                                	'.$vehicle_detail.'
                            </td>
                            <td width="20" align="left" valign="top">&nbsp;</td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td width="20" align="left" valign="top">
                    <table border="0" cellspacing="0" cellpadding="0" style="background-color: #74BF4C;padding: 12px 9px;width:100%">
                        <tr>
                            <td align="left" valign="top" width="200">
                                <h2 style="font-size: 24px;color: #fff;text-decoration:none; margin:0;">Service packages</h2></td>
                            <td align="left" valign="top" style="padding:10px 0; ">

                            </td>
                        </tr>

                    </table>
                </td>
            </tr>
            <tr>
                <td width="20" align="right" valign="top">
                    <table style="width:100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td align="left" valign="top" style="padding:10px 0;width:50%">
                                <table border="0" cellspacing="0" cellpadding="0" style="    padding: 12px 6px;width:100%" class="table table-striped table-bordered table-responsive dataTable no-footer">
                                    <thead>
                                        <tr style="background-color: #ccc;">
                                            <th width="20" style="border: 1px solid #eeeeee; padding: 10px 0;">Main Service</th>
                                            <th width="20" style="border: 1px solid #eeeeee;">Duration </th>
                                            <th width="20" style="border: 1px solid #eeeeee;">Cost </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            '.$main_service.'

                                        </tr>
                                    </tbody>
                                </table>

                            </td>
                            <td align="right" valign="top" style="padding:10px 0;width:50%">
                                '.$added_service.'
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td width="20" align="right" valign="top">
                    <table border="0" cellspacing="0" cellpadding="0" style="padding: 12px 6px;width:100%" class="table table-striped table-bordered table-responsive dataTable no-footer">
                        <thead>
                            <tr style="background-color: #ccc;">
                                <th width="20" style="border: 1px solid #eeeeee; padding: 10px 0;"></th>
                                <th width="20" style="border: 1px solid #eeeeee; padding: 10px 0;">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="background-color: #ccc;">
                                <td width="20" align="right" style="border: 1px solid #eeeeee; padding: 10px 6px;"><strong>Sub Total</strong></td>
                                <td width="20" style="border: 1px solid #eeeeee; text-align: center;"><strong>'.$sub_total_amount.'</strong></td>

                            </tr>
                            <tr style="background-color: #ccc;">
                                <td width="20" align="right" style="border: 1px solid #eeeeee; padding: 10px 6px;"><strong>Credit</strong></td>
                                <td width="20" style="border: 1px solid #eeeeee; text-align: center;"><strong>'.$credit_amount.'</strong></td>

                            </tr>
                            <tr style="background-color: #ccc;">
                                <td width="20" align="right" style="border: 1px solid #eeeeee; padding: 10px 6px;"><strong>Total</strong></td>
                                <td width="20" style="border: 1px solid #eeeeee; text-align: center;"><strong>'.$total_amount.'</strong></td>

                            </tr>
                        </tbody>

            </tr>
            </table>
</div>';
	$dompdf->loadHtml($put_data);
	$dompdf->setPaper('A3', 'portrat');
	$dompdf->render();
	echo $final=$dompdf->stream($name.".pdf");
/*}else {
	header("Location:index.php");
}*/
?>