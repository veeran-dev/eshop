
/*Dont touch the second step unless the table didn't accept the Engine type*/
ALTER TABLE  `kob_search_word` ENGINE = MYISAM ;

/*First step*/
ALTER TABLE kob_search_word
ADD FULLTEXT INDEX word
(word)