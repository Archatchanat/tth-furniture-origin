<div class="menu">
	<ul id="nav"> 
  		<li><a href="home.php">หน้าแรก</a></li>
        <? if ($_SESSION["str_admin_level"]=="Top") { ?>
		<li><a href="admin.php">ผู้ดูแลระบบ</a> </li>
        <li><a href="company.php">ชื่อบริษัท</a></li>
        <li><a href="company1.php">เลขผู้เสียภาษี</a></li>
         <li><a href="bid.php">ชื่อผู้เสนอราคา</a></li>
		<? } ?>
         <li><a href="#">สถานะต่างๆ</a>
         <ul>
         <li><a href="status_billing.php?id_s=1">สถานะออกใบเสนอราคา</a></li> 
          <li><a href="status_billing.php?id_s=2">สถานะออกใบวางบิล</a></li> 
           <li><a href="status_billing.php?id_s=3">สถานะออกใบเสร็จรับเงิน</a></li> 
          </ul>
         </li>
          <li><a href="note.php">นัดพบลูกค้า</a></li>
         <li><a href="project_category.php">หมวดหมู่โปรเจค</a></li>
         <li><a href="ex.php">รายละเอียดค่าใช้จ่าย</a></li>
       <!-- <li><a href="payment.php">เงื่อนไขการชำระเงิน</a></li> -->
         <li><a href="customers.php">ชื่อลูกค้า</a></li>
         <li><a href="billing.php">ออกใบเสนอราคา</a></li>
         <li><a href="billing1.php">ออกใบวางบิล</a></li>
         <li><a href="billing2.php">ออกใบเสร็จรับเงิน</a></li>
         <li><a href="re_project.php">รายงานหมวดหมู่โปรเจค</a></li>
         <li><a href="re_project.php">report ต่างๆ </a></li>
         <li><a href="#">reportรวม</a>
         <ul>
         <li><a href="re_billing_all.php">report ใบเสนอราคา</a></li> 
          <li><a href="re_billing1_all.php">report ใบวางบิล</a></li> 
         </ul>
         <li><a href="#">กราฟสรุปยอดใบเสนอราคา</a>
         <ul>
         <li><a href="graph_billing.php">กราฟสรุปยอดรายเดือน</a></li> 
          <li><a href="graph_billing_y.php">กราฟสรุปยอดรายปี</a></li> 
         </ul>
         </li>
           <li><a href="#">กราฟสรุปยอดใบวางบิล</a>
         <ul>
         <li><a href="graph_billing2.php">กราฟสรุปยอดรายเดือน</a></li> 
         </ul>
         </li> 
           <li><a href="re_billing1_s.php">สรุปยอดใบวางบิล</a>
         </li> 
	</ul>
</div>