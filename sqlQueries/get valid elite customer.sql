SELECT a.company,c.firstname,c.lastname,gl.name as group_name,a.address1,a.city,s.name as state,a.postcode, a.phone_mobile,c.email FROM `kob_customer` as  c
left join kob_address as a on c.id_customer = a.id_customer
left join kob_group_lang as gl on gl.id_group = c.id_default_group
left join kob_state as s on s.id_state = a.id_state
where gl.id_lang= 1 and c.id_buyer = 3 and c.active = 1 and c.deleted = 0 and id_default_group not in (0,1) order by gl.name asc