<?php
//require(__DIR__ . '/../include/Database.class.php');

// saving for later
// I'd like to implement PHPUnit

$db = new Database('read');

$results = $db->write('DROP TABLE IF EXISTS test');

$results = $db->write('CREATE TABLE IF NOT EXISTS test (
	id INTEGER AUTO_INCREMENT NOT NULL,
	title varchar(50) NOT NULL,
	format ENUM("VHS","DVD","Streaming") NOT NULL,
	length SMALLINT UNSIGNED NOT NULL,
	release_year SMALLINT UNSIGNED NOT NULL,
	rating TINYINT UNSIGNED NOT NULL,
	CONSTRAINT CHK_release_year CHECK (release_year >= 1800 AND release_year <= 2100),
	CONSTRAINT CHK_length CHECK (length >= 0 AND length <= 500),
	CONSTRAINT CHK_rating CHECK (rating >= 1 AND rating <= 5),
	INDEX IDX_title (title),
	INDEX IDX_format (format),
	INDEX IDX_length (length),
	INDEX IDX_release_year (release_year),
	INDEX IDX_rating (rating),
	PRIMARY KEY(id))');

$formats = array('VHS','DVD','Streaming');
for ($i=0; $i <= 10; $i++) {
	shuffle($formats);

	$title='title' . $i;
	$format = $formats[0];
	$length = rand(0,1500);
	$release_year = rand(1800,2100);
	$rating = rand(1,5);

	$results = $db->write('INSERT INTO test (title,format,length,release_year,rating) VALUES (?,?,?,?,?)', 'ssiii', array($title,$format,$length,$release_year,$rating));
}

//$results = $db->read('SELECT * FROM test WHERE title=?', 's', array($title));
$results = $db->read('SELECT * FROM test');
echo "number of results: " . count($results) . "\n";
print_r($results);

$results = $db->write('DROP TABLE IF EXISTS test');

?>
