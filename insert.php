<?php

//insert.php

include('database_connection.php');

$form_data = json_decode(file_get_contents("php://input"));

$error = '';
$message = '';
$validation_error = '';
$first = '';
$last = '';

if($form_data->action == 'fetch_single_data')
{
	$query = "
	SELECT * FROM `therapists` WHERE `id`='".$form_data->id."'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$output['first'] = $row['first'];
		$output['last'] = $row['last'];
		$output['name'] = $row['name'];
		$output['title_zone'] = $row['title_zone'];
		$output['title_lifting'] = $row['title_lifting'];
		$output['address'] = $row['address'];
		$output['city'] = $row['city'];
		$output['state'] = $row['state'];
		$output['country'] = $row['country'];
		$output['email'] = $row['email'];
		$output['phone'] = $row['phone'];
		$output['web'] = $row['web'];
		$output['lat'] = $row['lat'];
		$output['lng'] = $row['lng'];
		$output['countrycode'] = $row['countrycode'];
	}
}
elseif($form_data->action == "Delete")
{
	$query = "
	DELETE FROM `therapists` WHERE `id`='".$form_data->id."'
	";
	$statement = $connect->prepare($query);
	if($statement->execute()) {
		$output['message'] = 'Data Deleted';
	}
}
else
{
	if(empty($form_data->email))
	{
		$error[] = 'Email is Required';
	}
	else
	{
		$email = $form_data->$email;
	}

	if(empty($form_data->countrycode))
	{
		$error[] = 'countrycode is Required';
	}
	else
	{
		$countrycode = $form_data->countrycode;
	}

	$first = $form_data->first;
	$last = $form_data->last;
	$name = $form_data->name;
	$title_zone = $form_data->title_zone;
	$title_lifting = $form_data->title_lifting;
	$address = $form_data->address;
	$city = $form_data->city;
	$state = $form_data->state;
	$country = $form_data->country;
	$phone = $form_data->phone;
	$web = $form_data->web;
	$lat = $form_data->lat;
	$lng = $form_data->lng;

	if(empty($error))
	{
		if($form_data->action == 'Insert')
		{
			$data = array(
				':first'	=>	$first,
				':last'	=>	$last,
				':name'	=>	$first,
				':title_zone'	=>	$title_zone,
				':title_lifting'	=>	$title_lifting,
				':address'	=>	$address,
				':city'	=>	$city,
				':state'	=>	$state,
				':country'	=>	$country,
				':email'	=>	$email,
				':phone'	=>	$phone,
				':web'	=>	$web,
				':lat'	=>	$lat,
				':lng'	=>	$lng,
				':countrycode'	=>	$countrycode
			);
			$query = "
			INSERT INTO `therapists`
				(first, last, name,title_zone,title_lifting,country,email,address, city, state,
				phone,web,lat,lng, countrycode) VALUES
				(:first, :last, :name,:title_zone,:title_lifting,:country,:email,:address, :city, :state,
				:phone,:web,:lat,:lng, :countrycode)
			";
			$statement = $connect->prepare($query);
			if($statement->execute($data))
			{
				$message = 'Data Inserted';
			}
		}
		if($form_data->action == 'Edit')
		{
			$data = array(
				':first'	=>	$first,
				':last'	=>	$last,
				':name'	=>	$first,
				':title_zone'	=>	$title_zone,
				':title_lifting'	=>	$title_lifting,
				':address'	=>	$address,
				':city'	=>	$city,
				':state'	=>	$state,
				':country'	=>	$country,
				':email'	=>	$email,
				':phone'	=>	$phone,
				':web'	=>	$web,
				':lat'	=>	$lat,
				':lng'	=>	$lng,
				':countrycode'	=>	$countrycode,
				':id'			=>	$form_data->id
			);
			$query = "
			UPDATE `therapists`
			SET first = :first,
			last = :last,
			title_zone = :title_zone,
			title_lifting = :title_lifting,
			name = :name,
			address = :address,
			city = :city,
			state = :state,
			country = :country,
			email = :email,
			phone = :phone,
			web = :web,
			countrycode = :countrycode,
			lat = :lat,
			lng = :lng
			WHERE id = :id
			";

			$statement = $connect->prepare($query);
			if($statement->execute($data))
			{
				$message = 'Data Edited';
			}
		}
	}
	else
	{
		$validation_error = implode(", ", $error);
	}

	$output = array(
		'error'		=>	$validation_error,
		'message'	=>	$message
	);

}

echo json_encode($output);

?>
