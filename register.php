<?php


/*
=====================================================================
autoload all classses
=====================================================================
*/
spl_autoload_register(function($class) {
    include 'classes/' . $class . '.php';
});

/*
=====================================================================
INSTANTIATE CONNECTION VARIABLE
=====================================================================
*/
$newdb = new DB; 
$connect = $newdb->getConn();
$crud = new Crud($connect);

//intiate form variables
$firstname = '';
$lastname = '';
$address = '';
$country = '';
$state = '';
$city = '';
$phone = '';
$postal = '';
$email = '';
$form_of_contact = "";
$contact = "";
$frequency = "";
$payment = "";
$amount = 0;
$comment = "";

$error_array = [];
$top_error = '';

    
if (isset($_POST['finish'])) {
    // prevent sql injections/ clear user invalid inputs
    $firstname = htmlspecialchars(strip_tags(trim($_POST['firstname'])));
    $lastname = htmlspecialchars(strip_tags(trim($_POST['lastname'])));
    $address = htmlspecialchars(strip_tags(trim($_POST['address'])));
    $country = htmlspecialchars(strip_tags(trim($_POST['country'])));
    $state = htmlspecialchars(strip_tags(trim($_POST['state'])));
    $city = htmlspecialchars(strip_tags(trim($_POST['city'])));
    $phone = htmlspecialchars(strip_tags(trim($_POST['phone'])));
    $postal = htmlspecialchars(strip_tags(trim($_POST['postal'])));
    $email = htmlspecialchars(strip_tags(trim($_POST['email'])));
    $amount = htmlspecialchars(strip_tags(trim($_POST['amount'])));
    $comment = htmlspecialchars(strip_tags(trim($_POST['comment'])));
    $form_of_contact = htmlspecialchars(strip_tags(trim($_POST['form_of_contact'])));
    $frequency = htmlspecialchars(strip_tags(trim($_POST['frequency'])));
    $payment = htmlspecialchars(strip_tags(trim($_POST['payment'])));
    


    //server side input validation
    if (empty($firstname)) { 
        $error = true;
        array_push($error_array,  "Please enter your Firstname.");
    }
    if (empty($lastname)) { 
        $error = true;
        array_push($error_array, "Please enter your Lastname.");
    }
    if (empty($address)) { 
        $error = true;
        array_push($error_array,"Please enter your Address.");
    }
    if ($country == "") { 
        $error = true;
        array_push($error_array, "Please enter your Country.");
    }
    if (empty($city)) { 
        $error = true;
        array_push($error_array, "Please enter your City.");
    }
    if (empty($state)) { 
        $error = true;
        array_push($error_array, "Please enter your State.");
    }


    if (empty($phone)) { 
        $error = true;
        array_push($error_array, "Please enter your Phone Number.");
    }
    
    if (empty($postal)) { 
        $error = true;
        array_push($error_array, "Please enter your Postal code.");
    }
    
    if (empty($email)) { 
        $error = true;
        array_push($error_array, "Please enter your Email.");
    }
    
    if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
        $error = true;
        array_push($error_array, "Please enter valid email address.");
    } else {
        // check email exist or not
        $query = "email='$email'";
        $result =   $crud->select("prospective_donors",'*',$query);
        if($result){
        $error = true;
        array_push($error_array, "Provided Email is already in use.");
        }
    }

    $added=date("Y-m-d h:i:s");

    if (count($error_array) < 1) {



        
        $add = $crud->insert("prospective_donors", array(
        "firstName"=>$firstname,
        "lastName"=>$lastname,
        "email"=>$email,
        "city"=>$city,
        "state"=>$state,
        "country"=>$country,
        "phoneNo"=>$phone,
        "address"=>$address,
        "postal"=>$postal,
        "form_of_contact"=>$form_of_contact,
        "form_of_payment"=>$payment,
        "frequency"=>$frequency,
        "amount"=>$amount,
        "added"=>$added,
        "comment"=>$comment));

        if(!$add){
            
        }
        else{
            header("Location: reg_success.php");
            exit;
        }
            
    }
    else {
        $top_error = "Fill all the required fields";
    }

}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="https://assets.hakeema.com/matterfund/unit/59de0f711302974b90b8194a-8e853a.png" />
	<title>Associate Engineer Technical Task</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

	<!-- CSS Files -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
	<link href="assets/css/paper-bootstrap-wizard.css" rel="stylesheet" />

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link href="assets/css/demo.css" rel="stylesheet" />

	<!-- Fonts and Icons -->
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.css" rel="stylesheet">
	<link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/themify-icons.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
</head>

<body>
<div class="image-container set-full-height">
	<!--   Big container   -->
    <div class="container">
	       <div class="jumbotron">
           <div class="row">
                <div class="col-sm-10">
                    <?php for ($i = 0; $i < sizeof($error_array); $i ++) {?>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4><i class="icon fa fa-info"></i> Alert!</h4>
                            <h3><?php echo $error_array[$i] ?></h3>
                        </div>
                    <?php
                    }
                    if ($top_error) { ?>
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-info"></i> Alert!</h4>
                        <h3><?php echo $top_error ?></h3>
                    </div>
                <?php } ?>
                </div>
            </div>
            <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <!--      Wizard container        -->
                        <div class="wizard-container">

                            <div class="card wizard-card" data-color="orange" id="wizardProfile">
                                <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
                                    <!--        You can switch " data-color="orange" "  with one of the next bright colors: "blue", "green", "orange", "red", "azure"          -->

                                    <div class="wizard-header text-center">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6 col-md-offset-3 text-center" style="height: 80px; margin-top: 50px; margin-bottom: 80px">
                                                <img src="https://assets.hakeema.com/matterfund/unit/59de0f711302974b90b8194a-8e853a.png" class="big-logo" style="width:250px; margin-top: -70px;">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="wizard-navigation">
                                        <div class="progress-with-circle">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="1" aria-valuemin="1" aria-valuemax="3" style="width: 21%;"></div>
                                        </div>
                                        <ul>
                                            <li>
                                                <a href="#security" data-toggle="tab">
                                                    <div class="icon-circle">
                                                        <i class="ti-user"></i>
                                                    </div>
                                                    Personal Details
                                                </a>
                                            </li>
                                            <li>
                                                <a   href="#registration"  data-toggle="tab">
                                                    <div class="icon-circle">
                                                        <i class="ti-user"></i>
                                                    </div>
                                                    Review Personal Details
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tab-content">
                                        
                                    <div class="tab-pane" id="registration">
                                            <h5 class="info-text"> Please fill in your details </h5>
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="firstname" class="col-md-12 control-label">First Name</label>
                                                    <div class="col-md-12">
                                                        <input   disabled    name="firstname" required="required" id="firstname1" class="form-control"
                                                            placeholder="Enter First Name" maxlength="50" value="<?=$firstname ?>" type="text">
                                                    </div><br><br><br>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="lastname" class="col-md-12 control-label">Last Name</label>
                                                    <div class="col-md-12">
                                                        <input   disabled    name="lastname" required="required" id="lastname1" class="form-control"
                                                            placeholder="Enter Last Name" maxlength="50" value="<?=$lastname ?>" type="text">
                                                    </div><br><br><br>
                                                </div>
                                                <div class="form-group">
                                                    <label for="address" class="col-md-12 control-label">Address</label>
                                                    <div class="col-md-12">
                                                        <textarea disabled    name="address" required="required" id="address1" class="form-control" placeholder="Enter Address"
                                                        maxlength="200" value="<?=$address ?>"></textarea><br>
                                                    </div>
                                                </div>

                                                <div class="row" style="margin-bottom: 50px">
                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group">
                                                            <label for="country" class="col-md-12 control-label">Country</label>
                                                            <div class="col-md-12">
                                                            <input   disabled    id="Country1" class="form-control"    type="text">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group">
                                                            <label for="state" class="col-md-12 control-label">State</label>
                                                            <div class="col-md-12">
                                                                <input   disabled    name="state" required="required" id="state1" class="form-control" placeholder="Enter State"
                                                                    maxlength="50" value="<?=$state ?>" type="text">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group">
                                                            <label for="city" class="col-md-12 control-label">City</label>
                                                            <div>
                                                                <input   disabled    name="city" required="required" id="city1" class="form-control" placeholder="Enter City"
                                                                    maxlength="50" value="<?=$city ?>" type="text">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group">
                                                            <label for="postal" class="col-md-12 control-label">Postal Code</label>
                                                            <div class="col-md-12">
                                                                <input   disabled    type="text" required="required" name="postal1" id="postal1" value="<?=$postal ?>" class="form-control">
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group">
                                                            <label for="email" class="col-md-12 control-label">Email</label>
                                                            <div class="col-md-12">
                                                                <input   disabled    type="email" class="form-control" name="email" id="email1" maxlength="40"
                                                                    placeholder="Email Address" value="<?=$email ?>">
                                                            </div>
                                                            <div class="col-md-1" style="padding-top: 10px; padding-left: 0px">
                                                                <span id="referer_success" class="glyphicon glyphicon-ok success" style="color: rgba(46,148,15,0.99); display: none"></span>
                                                                <span class="glyphicon glyphicon-remove referer_error1" style="color: red; display: none;"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group">
                                                            <label for="phone" class="col-md-12 control-label">Phone</label>
                                                            <div class="col-md-12">
                                                                <input id="phone1"   disabled    name="phone" required="required" class="form-control" placeholder="Enter phone number"
                                                                    maxlength="50" value="<?=$phone ?>" type="text">
                                                            </div>
                                                        </div>
                                                            <div class="col-md-1" style="padding-top: 10px; padding-left: 0px">
                                                            </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group">
                                                            <label for="form_of_contact" class="col-md-12 control-label">Preferred form of contact</label>
                                                            <div class="col-md-12">
                                                                <select  disabled    class="form-control" required="required" name="form_of_contact1" id="form_of_contact1">
                                                                    <option value="">Select Option</option>
                                                                    <option value="phone" <?php if ($form_of_contact == 'phone') echo 'selected' ?>>Phone</option>
                                                                    <option value="email" <?php if ($form_of_contact == 'email') echo 'selected' ?>>Email</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group">
                                                            <label for="payment" class="col-md-12 control-label">Preferred form of payment</label>
                                                            <div class="col-md-12">
                                                                <select  disabled    class="form-control" required="required" name="payment" id="payment1">
                                                                    <option value="">Select Payment Form</option>
                                                                    <option value="USD" <?php if ($payment == 'USD') echo 'selected' ?>>USD</option>
                                                                    <option value="Euro" <?php if ($payment == 'Euro') echo 'selected' ?>>Euro</option>
                                                                    <option value="Bitcoin" <?php if ($payment == 'Bitcoin') echo 'selected' ?>>Bitcoin</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group">
                                                            <label for="Frequency" class="col-md-12 control-label">Frequency of donation</label>
                                                            <div class="col-md-12">
                                                                <select  disabled    class="form-control" required="required" name="frequency" id="frequency1">
                                                                    <option value="">Select Frequency</option>
                                                                    <option value="Monthly" <?php if ($frequency == 'Monthly') echo 'selected' ?>>Monthly</option>
                                                                    <option value="Yearly" <?php if ($frequency == 'Yearly') echo 'selected' ?>>Yearly</option>
                                                                    <option value="One-time" <?php if ($frequency == 'One-time') echo 'selected' ?>>One-time</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group">
                                                            <label  for="pass" class="col-md-12 control-label">Donation Amount</label>
                                                            <div class="col-md-12">
                                                                <input   disabled    required="required"  value="<?=$amount ?>"   name="amount" id="amount1" class="form-control" placeholder="Enter Password" maxlength="15"
                                                                        type="number">
                                                            </div>
                                                        </div>
                                                        <div class="form-group" style="height: 10px !important">
                                                            <label class="col-md-12 amount_error" style="color: red; font-weight: bold; display: none">Please input any Amount above 0</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label  for="pass" class="col-md-12 control-label">Comments</label>
                                                            <div class="col-md-12">
                                                            <textarea disabled     value="<?=$comment ?>"   required="required"  name="comment" id="comment1" class="form-control"
                                                                        maxlength="15" type="text">
                                                                        </textarea>
                                                            </div>
                                                        </div>
                                                        <div class="form-group" style="height: 10px !important">
                                                            <label class="col-md-12" id="comment_success" style="color: rgba(46,148,15,0.99); font-weight: bold; display: none">Comment taken</label>
                                                            <label class="col-md-12 comment_error" style="color: red; font-weight: bold; display: none">Comment is compulsory</label>
                                                        </div>
                                                    </div>
                                                </div><br><br>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="security">
                                            <h5 class="info-text"> Please fill in your details </h5>
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="firstname" class="col-md-12 control-label">First Name</label>
                                                    <div class="col-md-12">
                                                        <input name="firstname" required="required" id="firstname" class="form-control"
                                                            placeholder="Enter First Name" maxlength="50" value="<?=$firstname ?>" type="text">
                                                    </div><br><br><br>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="lastname" class="col-md-12 control-label">Last Name</label>
                                                    <div class="col-md-12">
                                                        <input name="lastname" required="required" id="lastname" class="form-control"
                                                            placeholder="Enter Last Name" maxlength="50" value="<?=$lastname ?>" type="text">
                                                    </div><br><br><br>
                                                </div>
                                                <div class="form-group">
                                                    <label for="address" class="col-md-12 control-label">Address</label>
                                                    <div class="col-md-12">
                                                        <textarea name="address" required="required" id="address" class="form-control" placeholder="Enter Address"
                                                        maxlength="200" value="<?=$address ?>"></textarea><br>
                                                    </div>
                                                </div>

                                                <div class="row" style="margin-bottom: 50px">
                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group">
                                                            <label for="country" class="col-md-12 control-label">Country</label>
                                                            <div class="col-md-12">
                                                                <select name="country" required="required" id="Country" class="form-control" value="">
                                                                    <option value="">Select Country</option>
                                                                    <option value="Afghanistan">Afghanistan</option>
                                                                    <option value="Albania">Albania</option>
                                                                    <option value="Algeria">Algeria</option>
                                                                    <option value="American Samoa">American Samoa</option>
                                                                    <option value="Andorra">Andorra</option>
                                                                    <option value="Angola">Angola</option>
                                                                    <option value="Anguilla">Anguilla</option>
                                                                    <option value="Antartica">Antarctica</option>
                                                                    <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                                                    <option value="Argentina">Argentina</option>
                                                                    <option value="Armenia">Armenia</option>
                                                                    <option value="Aruba">Aruba</option>
                                                                    <option value="Australia">Australia</option>
                                                                    <option value="Austria">Austria</option>
                                                                    <option value="Azerbaijan">Azerbaijan</option>
                                                                    <option value="Bahamas">Bahamas</option>
                                                                    <option value="Bahrain">Bahrain</option>
                                                                    <option value="Bangladesh">Bangladesh</option>
                                                                    <option value="Barbados">Barbados</option>
                                                                    <option value="Belarus">Belarus</option>
                                                                    <option value="Belgium">Belgium</option>
                                                                    <option value="Belize">Belize</option>
                                                                    <option value="Benin">Benin</option>
                                                                    <option value="Bermuda">Bermuda</option>
                                                                    <option value="Bhutan">Bhutan</option>
                                                                    <option value="Bolivia">Bolivia</option>
                                                                    <option value="Bosnia and Herzegowina">Bosnia and Herzegowina</option>
                                                                    <option value="Botswana">Botswana</option>
                                                                    <option value="Bouvet Island">Bouvet Island</option>
                                                                    <option value="Brazil">Brazil</option>
                                                                    <option value="British Indian Ocean Territory">British Indian Ocean Territory
                                                                    </option>
                                                                    <option value="Brunei Darussalam">Brunei Darussalam</option>
                                                                    <option value="Bulgaria">Bulgaria</option>
                                                                    <option value="Burkina Faso">Burkina Faso</option>
                                                                    <option value="Burundi">Burundi</option>
                                                                    <option value="Cambodia">Cambodia</option>
                                                                    <option value="Cameroon">Cameroon</option>
                                                                    <option value="Canada">Canada</option>
                                                                    <option value="Cape Verde">Cape Verde</option>
                                                                    <option value="Cayman Islands">Cayman Islands</option>
                                                                    <option value="Central African Republic">Central African Republic</option>
                                                                    <option value="Chad">Chad</option>
                                                                    <option value="Chile">Chile</option>
                                                                    <option value="China">China</option>
                                                                    <option value="Christmas Island">Christmas Island</option>
                                                                    <option value="Cocos Islands">Cocos (Keeling) Islands</option>
                                                                    <option value="Colombia">Colombia</option>
                                                                    <option value="Comoros">Comoros</option>
                                                                    <option value="Congo">Congo</option>
                                                                    <option value="Congo">Congo, the Democratic Republic of the</option>
                                                                    <option value="Cook Islands">Cook Islands</option>
                                                                    <option value="Costa Rica">Costa Rica</option>
                                                                    <option value="Cota D'Ivoire">Cote d'Ivoire</option>
                                                                    <option value="Croatia">Croatia (Hrvatska)</option>
                                                                    <option value="Cuba">Cuba</option>
                                                                    <option value="Cyprus">Cyprus</option>
                                                                    <option value="Czech Republic">Czech Republic</option>
                                                                    <option value="Denmark">Denmark</option>
                                                                    <option value="Djibouti">Djibouti</option>
                                                                    <option value="Dominica">Dominica</option>
                                                                    <option value="Dominican Republic">Dominican Republic</option>
                                                                    <option value="East Timor">East Timor</option>
                                                                    <option value="Ecuador">Ecuador</option>
                                                                    <option value="Egypt">Egypt</option>
                                                                    <option value="El Salvador">El Salvador</option>
                                                                    <option value="Equatorial Guinea">Equatorial Guinea</option>
                                                                    <option value="Eritrea">Eritrea</option>
                                                                    <option value="Estonia">Estonia</option>
                                                                    <option value="Ethiopia">Ethiopia</option>
                                                                    <option value="Falkland Islands">Falkland Islands (Malvinas)</option>
                                                                    <option value="Faroe Islands">Faroe Islands</option>
                                                                    <option value="Fiji">Fiji</option>
                                                                    <option value="Finland">Finland</option>
                                                                    <option value="France">France</option>
                                                                    <option value="France Metropolitan">France, Metropolitan</option>
                                                                    <option value="French Guiana">French Guiana</option>
                                                                    <option value="French Polynesia">French Polynesia</option>
                                                                    <option value="French Southern Territories">French Southern Territories</option>
                                                                    <option value="Gabon">Gabon</option>
                                                                    <option value="Gambia">Gambia</option>
                                                                    <option value="Georgia">Georgia</option>
                                                                    <option value="Germany">Germany</option>
                                                                    <option value="Ghana">Ghana</option>
                                                                    <option value="Gibraltar">Gibraltar</option>
                                                                    <option value="Greece">Greece</option>
                                                                    <option value="Greenland">Greenland</option>
                                                                    <option value="Grenada">Grenada</option>
                                                                    <option value="Guadeloupe">Guadeloupe</option>
                                                                    <option value="Guam">Guam</option>
                                                                    <option value="Guatemala">Guatemala</option>
                                                                    <option value="Guinea">Guinea</option>
                                                                    <option value="Guinea-Bissau">Guinea-Bissau</option>
                                                                    <option value="Guyana">Guyana</option>
                                                                    <option value="Haiti">Haiti</option>
                                                                    <option value="Heard and McDonald Islands">Heard and Mc Donald Islands</option>
                                                                    <option value="Holy See">Holy See (Vatican City State)</option>
                                                                    <option value="Honduras">Honduras</option>
                                                                    <option value="Hong Kong">Hong Kong</option>
                                                                    <option value="Hungary">Hungary</option>
                                                                    <option value="Iceland">Iceland</option>
                                                                    <option value="India">India</option>
                                                                    <option value="Indonesia">Indonesia</option>
                                                                    <option value="Iran">Iran (Islamic Republic of)</option>
                                                                    <option value="Iraq">Iraq</option>
                                                                    <option value="Ireland">Ireland</option>
                                                                    <option value="Israel">Israel</option>
                                                                    <option value="Italy">Italy</option>
                                                                    <option value="Jamaica">Jamaica</option>
                                                                    <option value="Japan">Japan</option>
                                                                    <option value="Jordan">Jordan</option>
                                                                    <option value="Kazakhstan">Kazakhstan</option>
                                                                    <option value="Kenya">Kenya</option>
                                                                    <option value="Kiribati">Kiribati</option>
                                                                    <option value="Democratic People's Republic of Korea">Korea, Democratic People's
                                                                        Republic of
                                                                    </option>
                                                                    <option value="Korea">Korea, Republic of</option>
                                                                    <option value="Kuwait">Kuwait</option>
                                                                    <option value="Kyrgyzstan">Kyrgyzstan</option>
                                                                    <option value="Lao">Lao People's Democratic Republic</option>
                                                                    <option value="Latvia">Latvia</option>
                                                                    <option value="Lebanon">Lebanon</option>
                                                                    <option value="Lesotho">Lesotho</option>
                                                                    <option value="Liberia">Liberia</option>
                                                                    <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                                                                    <option value="Liechtenstein">Liechtenstein</option>
                                                                    <option value="Lithuania">Lithuania</option>
                                                                    <option value="Luxembourg">Luxembourg</option>
                                                                    <option value="Macau">Macau</option>
                                                                    <option value="Macedonia">Macedonia, The Former Yugoslav Republic of</option>
                                                                    <option value="Madagascar">Madagascar</option>
                                                                    <option value="Malawi">Malawi</option>
                                                                    <option value="Malaysia">Malaysia</option>
                                                                    <option value="Maldives">Maldives</option>
                                                                    <option value="Mali">Mali</option>
                                                                    <option value="Malta">Malta</option>
                                                                    <option value="Marshall Islands">Marshall Islands</option>
                                                                    <option value="Martinique">Martinique</option>
                                                                    <option value="Mauritania">Mauritania</option>
                                                                    <option value="Mauritius">Mauritius</option>
                                                                    <option value="Mayotte">Mayotte</option>
                                                                    <option value="Mexico">Mexico</option>
                                                                    <option value="Micronesia">Micronesia, Federated States of</option>
                                                                    <option value="Moldova">Moldova, Republic of</option>
                                                                    <option value="Monaco">Monaco</option>
                                                                    <option value="Mongolia">Mongolia</option>
                                                                    <option value="Montserrat">Montserrat</option>
                                                                    <option value="Morocco">Morocco</option>
                                                                    <option value="Mozambique">Mozambique</option>
                                                                    <option value="Myanmar">Myanmar</option>
                                                                    <option value="Namibia">Namibia</option>
                                                                    <option value="Nauru">Nauru</option>
                                                                    <option value="Nepal">Nepal</option>
                                                                    <option value="Netherlands">Netherlands</option>
                                                                    <option value="Netherlands Antilles">Netherlands Antilles</option>
                                                                    <option value="New Caledonia">New Caledonia</option>
                                                                    <option value="New Zealand">New Zealand</option>
                                                                    <option value="Nicaragua">Nicaragua</option>
                                                                    <option value="Niger">Niger</option>
                                                                    <option value="Nigeria">Nigeria</option>
                                                                    <option value="Niue">Niue</option>
                                                                    <option value="Norfolk Island">Norfolk Island</option>
                                                                    <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                                                                    <option value="Norway">Norway</option>
                                                                    <option value="Oman">Oman</option>
                                                                    <option value="Pakistan">Pakistan</option>
                                                                    <option value="Palau">Palau</option>
                                                                    <option value="Panama">Panama</option>
                                                                    <option value="Papua New Guinea">Papua New Guinea</option>
                                                                    <option value="Paraguay">Paraguay</option>
                                                                    <option value="Peru">Peru</option>
                                                                    <option value="Philippines">Philippines</option>
                                                                    <option value="Pitcairn">Pitcairn</option>
                                                                    <option value="Poland">Poland</option>
                                                                    <option value="Portugal">Portugal</option>
                                                                    <option value="Puerto Rico">Puerto Rico</option>
                                                                    <option value="Qatar">Qatar</option>
                                                                    <option value="Reunion">Reunion</option>
                                                                    <option value="Romania">Romania</option>
                                                                    <option value="Russia">Russian Federation</option>
                                                                    <option value="Rwanda">Rwanda</option>
                                                                    <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                                                                    <option value="Saint LUCIA">Saint LUCIA</option>
                                                                    <option value="Saint Vincent">Saint Vincent and the Grenadines</option>
                                                                    <option value="Samoa">Samoa</option>
                                                                    <option value="San Marino">San Marino</option>
                                                                    <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                                                                    <option value="Saudi Arabia">Saudi Arabia</option>
                                                                    <option value="Senegal">Senegal</option>
                                                                    <option value="Seychelles">Seychelles</option>
                                                                    <option value="Sierra">Sierra Leone</option>
                                                                    <option value="Singapore">Singapore</option>
                                                                    <option value="Slovakia">Slovakia (Slovak Republic)</option>
                                                                    <option value="Slovenia">Slovenia</option>
                                                                    <option value="Solomon Islands">Solomon Islands</option>
                                                                    <option value="Somalia">Somalia</option>
                                                                    <option value="South Africa">South Africa</option>
                                                                    <option value="South Georgia">South Georgia and the South Sandwich Islands
                                                                    </option>
                                                                    <option value="Span">Spain</option>
                                                                    <option value="SriLanka">Sri Lanka</option>
                                                                    <option value="St. Helena">St. Helena</option>
                                                                    <option value="St. Pierre and Miguelon">St. Pierre and Miquelon</option>
                                                                    <option value="Sudan">Sudan</option>
                                                                    <option value="Suriname">Suriname</option>
                                                                    <option value="Svalbard">Svalbard and Jan Mayen Islands</option>
                                                                    <option value="Swaziland">Swaziland</option>
                                                                    <option value="Sweden">Sweden</option>
                                                                    <option value="Switzerland">Switzerland</option>
                                                                    <option value="Syria">Syrian Arab Republic</option>
                                                                    <option value="Taiwan">Taiwan, Province of China</option>
                                                                    <option value="Tajikistan">Tajikistan</option>
                                                                    <option value="Tanzania">Tanzania, United Republic of</option>
                                                                    <option value="Thailand">Thailand</option>
                                                                    <option value="Togo">Togo</option>
                                                                    <option value="Tokelau">Tokelau</option>
                                                                    <option value="Tonga">Tonga</option>
                                                                    <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                                                    <option value="Tunisia">Tunisia</option>
                                                                    <option value="Turkey">Turkey</option>
                                                                    <option value="Turkmenistan">Turkmenistan</option>
                                                                    <option value="Turks and Caicos">Turks and Caicos Islands</option>
                                                                    <option value="Tuvalu">Tuvalu</option>
                                                                    <option value="Uganda">Uganda</option>
                                                                    <option value="Ukraine">Ukraine</option>
                                                                    <option value="United Arab Emirates">United Arab Emirates</option>
                                                                    <option value="United Kingdom">United Kingdom</option>
                                                                    <option value="United States">United States</option>
                                                                    <option value="United States Minor Outlying Islands">United States Minor
                                                                        Outlying Islands
                                                                    </option>
                                                                    <option value="Uruguay">Uruguay</option>
                                                                    <option value="Uzbekistan">Uzbekistan</option>
                                                                    <option value="Vanuatu">Vanuatu</option>
                                                                    <option value="Venezuela">Venezuela</option>
                                                                    <option value="Vietnam">Viet Nam</option>
                                                                    <option value="Virgin Islands (British)">Virgin Islands (British)</option>
                                                                    <option value="Virgin Islands (U.S)">Virgin Islands (U.S.)</option>
                                                                    <option value="Wallis and Futana Islands">Wallis and Futuna Islands</option>
                                                                    <option value="Western Sahara">Western Sahara</option>
                                                                    <option value="Yemen">Yemen</option>
                                                                    <option value="Yugoslavia">Yugoslavia</option>
                                                                    <option value="Zambia">Zambia</option>
                                                                    <option value="Zimbabwe">Zimbabwe</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group">
                                                            <label for="state" class="col-md-12 control-label">State</label>
                                                            <div class="col-md-12">
                                                                <input name="state" required="required" id="state" class="form-control" placeholder="Enter State"
                                                                    maxlength="50" value="<?=$state ?>" type="text">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group">
                                                            <label for="city" class="col-md-12 control-label">City</label>
                                                            <div>
                                                                <input name="city" required="required" id="city" class="form-control" placeholder="Enter City"
                                                                    maxlength="50" value="<?=$city ?>" type="text">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group">
                                                            <label for="postal" class="col-md-12 control-label">Postal Code</label>
                                                            <div class="col-md-12">
                                                                <input type="text" required="required" name="postal" id="postal" value="<?=$postal ?>" class="form-control">
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group">
                                                            <label for="email" class="col-md-12 control-label">Email</label>
                                                            <div class="col-md-12">
                                                                <input type="email" class="form-control" name="email" id="email" maxlength="40"
                                                                    placeholder="Email Address" value="<?=$email ?>">
                                                            </div>
                                                            <div class="col-md-1" style="padding-top: 10px; padding-left: 0px">
                                                                <span id="referer_success" class="glyphicon glyphicon-ok success" style="color: rgba(46,148,15,0.99); display: none"></span>
                                                                <span class="glyphicon glyphicon-remove referer_error" style="color: red; display: none;"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group">
                                                            <label for="phone" class="col-md-12 control-label">Phone</label>
                                                            <div class="col-md-12">
                                                                <input id="phone" name="phone" required="required" class="form-control" placeholder="Enter phone number"
                                                                    maxlength="50" value="<?=$phone ?>" type="text">
                                                            </div>
                                                        </div>
                                                            <div class="col-md-1" style="padding-top: 10px; padding-left: 0px">
                                                            </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group">
                                                            <label for="form_of_contact" class="col-md-12 control-label">Preferred form of contact</label>
                                                            <div class="col-md-12">
                                                                <select class="form-control" required="required" name="form_of_contact" id="form_of_contact">
                                                                    <option value="">Select Option</option>
                                                                    <option value="phone" <?php if ($form_of_contact == 'phone') echo 'selected' ?>>Phone</option>
                                                                    <option value="email" <?php if ($form_of_contact == 'email') echo 'selected' ?>>Email</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group">
                                                            <label for="payment" class="col-md-12 control-label">Preferred form of payment</label>
                                                            <div class="col-md-12">
                                                                <select class="form-control" required="required" name="payment" id="payment">
                                                                    <option value="">Select Payment Form</option>
                                                                    <option value="USD" <?php if ($payment == 'USD') echo 'selected' ?>>USD</option>
                                                                    <option value="Euro" <?php if ($payment == 'Euro') echo 'selected' ?>>Euro</option>
                                                                    <option value="Bitcoin" <?php if ($payment == 'Bitcoin') echo 'selected' ?>>Bitcoin</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group">
                                                            <label for="Frequency" class="col-md-12 control-label">Frequency of donation</label>
                                                            <div class="col-md-12">
                                                                <select class="form-control" required="required" name="frequency" id="frequency">
                                                                    <option value="">Select Frequency</option>
                                                                    <option value="Monthly" <?php if ($frequency == 'Monthly') echo 'selected' ?>>Monthly</option>
                                                                    <option value="Yearly" <?php if ($frequency == 'Yearly') echo 'selected' ?>>Yearly</option>
                                                                    <option value="One-time" <?php if ($frequency == 'One-time') echo 'selected' ?>>One-time</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <br><br>
                                                <div class="row">
                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group">
                                                            <label  for="pass" class="col-md-12 control-label">Amount of donation</label>
                                                            <div class="col-md-12">
                                                                <input required="required"  value="<?=$amount ?>"   name="amount" id="amount" class="form-control" placeholder="Enter Password" maxlength="15"
                                                                        type="number">
                                                            </div>
                                                        </div>
                                                        <div class="form-group" style="height: 10px !important">
                                                            <label class="col-md-12 amount_error" style="color: red; font-weight: bold; display: none">Please input any Amount above 0</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label  for="pass" class="col-md-12 control-label">Comments</label>
                                                            <div class="col-md-12">
                                                            <textarea name="comment" required="required" id="comment" class="form-control" placeholder="Enter Comments"
                                                        maxlength="200" value="<?=$comment ?>"></textarea><br>
                                                            </div>
                                                        </div>
                                                        <div class="form-group" style="height: 10px !important">
                                                            <label class="col-md-12" id="comment_success" style="color: rgba(46,148,15,0.99); font-weight: bold; display: none">Comment taken</label>
                                                            <label class="col-md-12 comment_error" style="color: red; font-weight: bold; display: none">Comment is compulsory</label>
                                                        </div>
                                                    </div>
                                                </div><br><br>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wizard-footer">
                                        <div class="pull-right">
                                            <input type='button' onclick="showValue()" class='btn btn-next btn-fill btn-warning btn-wd' name='next' value='Proceed' />
                                            <input type='submit' class='btn btn-finish btn-fill btn-warning btn-wd' name='finish' value='Finish' />
                                        </div>

                                        <div class="pull-left">
                                            <input type='button' class='btn btn-previous btn-default btn-wd' name='previous' value='Edit Form' />
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </form>
                            </div>
                        </div> <!-- wizard container -->
                    </div>
                </div><!-- end row -->
           </div>
	</div> <!--  big container -->
</div>
</body>
	<!--   Core JS Files   -->
	<script src="assets/js/jquery-2.2.4.min.js" type="text/javascript"></script>
	<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="assets/js/jquery.bootstrap.wizard.js" type="text/javascript"></script>

	<!--  Plugin for the Wizard -->
	<script src="assets/js/paper-bootstrap-wizard.js" type="text/javascript"></script>

	<!--  More information about jquery.validate here: http://jqueryvalidation.org/	 -->
	<script src="assets/js/jquery.validate.min.js" type="text/javascript"></script>
<script>

    function showValue() {
        document.getElementById('Country1').value = document.getElementById('Country').value;
        document.getElementById('payment1').value = document.getElementById('payment').value;
        document.getElementById('frequency1').value = document.getElementById('frequency').value;
        document.getElementById('form_of_contact1').value = document.getElementById('form_of_contact').value;
    }
$(document).ready(function () {

    // Returns a function, that, as long as it continues to be invoked, will not
            // be triggered. The function will be called after it stops being called for
            // N milliseconds. If `immediate` is passed, trigger the function on the
            // leading edge, instead of the trailing.
            function debounce(func, wait, immediate) {
                var timeout;
                return function() {
                    var context = this, args = arguments;
                    var later = function() {
                        timeout = null;
                        if (!immediate) func.apply(context, args);
                    };
                    var callNow = immediate && !timeout;
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                    if (callNow) func.apply(context, args);
                };
            };



            $('#amount').on('keyup', debounce(function(){
               $('#amount1').val($(this).val());
                if($('#amount').val() >0) {
                    $('.amount_error').hide();
                }
                else {
                    $('.amount_error').show();
                }

                
            }, 500));


            $('#firstname').on('keyup', debounce(function(){
               $('#firstname1').val($(this).val());
            }, 500));
            $('#email').on('keyup', debounce(function(){
               $('#email1').val($(this).val());
            
            }, 500));
            $('#firstname').on('keyup', debounce(function(){
               $('#firstname1').val($(this).val());
           
            }, 500));
            $('#lastname').on('keyup', debounce(function(){
               $('#lastname1').val($(this).val());
            
            }, 500));
            $('#address').on('keyup', debounce(function(){
               $('#address1').val($(this).val());
            
            }, 500));
            $('#state').on('keyup', debounce(function(){
               $('#state1').val($(this).val());
            
            }, 500));
            $('#city').on('keyup', debounce(function(){
               $('#city1').val($(this).val());
            
            }, 500));
            $('#postal').on('keyup', debounce(function(){
               $('#postal1').val($(this).val());
            
            }, 500));
            $('#comment').on('keyup', debounce(function(){
               $('#comment1').val($(this).val());
            
            }, 500));
            $('#phone').on('keyup', debounce(function(){
               $('#phone1').val($(this).val());
            
            }, 500));


      onsubmit = function(){
      }

});
function onSubmit(){
    document.getElementById('FormID').submit();
}
</script>
</html>
