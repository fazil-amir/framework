<div class="email-headline" style="<?php echo $emailHeadline; ?>" >Welcome to Xoxoday</div>

<div class="hello-name" style="<?php echo $helloName; ?>">Hi <?php echo $data['firstName']; ?>,</div>

<div class="paragraph" style="<?php echo $paragraph; ?>" >Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>

<div class="paragraph-small" style="<?php echo $paragraphSmall; ?>" >Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
tempor incididunt ut labore et dolore magna aliqua.</div>

<div class="paragraph" style="<?php echo $paragraph; ?>" ><a href="http://google.com" target="_blank" class="link" style="<?php echo $link; ?>"><span style="<?php echo $linkSpan; ?>">Link Here</span></a></div>

<div class="paragraph" style="<?php echo $paragraph; ?>" ><a href="http://google.com" target="_blank" class="button" style="<?php echo $button; ?>"><span style="<?php echo $buttonSpan; ?>">Button Name</span></a></div>

<div class="table-headline" style="<?php echo $tableHeadline; ?>">Order Details</div>

<table class="table" style="width: 100%;" border="0" cellpadding="10" cellspacing="0" style="<?php echo $table; ?>">
	<tr>
		<th style="<?php echo $tableTH; ?>">#</th>
		<th style="<?php echo $tableTH; ?>">Item Name</th>
		<th style="<?php echo $tableTH; ?>">Qty.</th>
		<th style="<?php echo $tableTH; ?>" align="right">Price(INR)</th>
	</tr>

	<?php $i = 1; while($i <= 5) { ?>
	
		<tr>
			<td style="<?php echo $tableTD; ?>" valign="top" align="center"><?php echo $i; ?></td>
			<td style="<?php echo $tableTD; ?>" valign="top">
				E-Gift Xoxo voucher, Amazon.in<br>
				<span style="font-size: 12px">Receiver’s email : pankaj@xoxoday.com</span>
			</td>
			<td style="<?php echo $tableTD; ?>" valign="top">100</td>
			<td style="<?php echo $tableTD; ?>" align="right" valign="top">10,000</td>
		</tr>
	
	<?php $i++; } ?>

	<tr class="total">
		<td style="<?php echo $totalTD; ?>" align="right" colspan="4">Total: 10,000</td>
	</tr>

</table>