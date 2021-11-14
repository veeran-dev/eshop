-----********PINCODE TABLE CHANGE*********---------


ALTER TABLE `kob_pincode_master`    
  ADD COLUMN `id_fulfillment_center` INT(10) NULL AFTER `zone_pin_end`;

	---------****PINCODE TABLE CHANGE*****-----------
	
	
	ALTER TABLE `kob_pincode_master`   
  CHANGE `zone_state` `id_state` INT(10) NULL;

  
  -------------*********************--------------------------