/*Alter order state table with id_profile column */
ALTER TABLE  `kob_order_state` ADD  `id_profile` INT( 11 ) NULL DEFAULT NULL AFTER  `deleted` ;

/*Add values to id_profile column in order state */
UPDATE `kob_order_state`
    SET `id_profile` = (CASE 
	    					WHEN `id_order_state` = 4 THEN 6 
	    					WHEN `id_order_state` = 5 THEN 13 
	    					WHEN `id_order_state` = 6 THEN 14 
	    					WHEN `id_order_state` = 7 THEN 14
	    					WHEN `id_order_state` = 9 THEN 13
	    					WHEN `id_order_state` = 18 THEN 6
	    					WHEN `id_order_state` = 19 THEN 6
	    					WHEN `id_order_state` = 21 THEN 6
	    					WHEN `id_order_state` = 22 THEN 6
	    					WHEN `id_order_state` = 23 THEN 5
	    					WHEN `id_order_state` = 24 THEN 6
	    					WHEN `id_order_state` = 25 THEN 13
	    					WHEN `id_order_state` = 26 THEN 13
	    					WHEN `id_order_state` = 27 THEN 13
	    					WHEN `id_order_state` = 28 THEN 5  					
	                     	WHEN `id_order_state` = 29 THEN 13
	                     	WHEN `id_order_state` = 30 THEN 13
	                     	WHEN `id_order_state` = 31 THEN 13
	                     	WHEN `id_order_state` = 32 THEN 5
	                     	WHEN `id_order_state` = 33 THEN 6
	                     	WHEN `id_order_state` = 34 THEN 13
	                     	WHEN `id_order_state` = 35 THEN 11
	                     	WHEN `id_order_state` = 36 THEN 13
	                     	WHEN `id_order_state` = 37 THEN 11
	                     	WHEN `id_order_state` = 38 THEN 14
	                     	WHEN `id_order_state` = 39 THEN 11
	                     	WHEN `id_order_state` = 40 THEN 13
	                     	WHEN `id_order_state` = 41 THEN 5
	                     	WHEN `id_order_state` = 42 THEN 13                	
	                     	WHEN `id_order_state` = 43 THEN 5
                    	END)
    WHERE `id_order_state` IN (`id_order_state`);