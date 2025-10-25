<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Form Validation</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center min-h-screen">

    <?php
    $errors = [];
    $success = false;
    $data = [];

    if (isset($_POST['submit'])) {
        $fname = validation($_POST['fname']);
        $lname = validation($_POST['lname']);
        $email = validation($_POST['email']);
        $country = $_POST['country'] ?? '';
        $password = validation($_POST['password']);
        $gender = $_POST['gender']?? '';
        $imageName = $_FILES['image']['name'];
        $imageType = $_FILES['image']['type'];
        $imageTmp=$_FILES['image']['tmp_name'];
        $imagesize=$_FILES['image']['size'];
      
      if(empty($imageName)){
        $errors['imageName'] = '⚠️ Please Upload your image.';
      }else{
        $data ['imageName'] = $imageName;
      }
        // First name validation
        if (empty($fname)) {
            $errors['fname'] = '⚠️ Please enter your first name.';
        } elseif (!preg_match("/^[a-zA-Z-' ]*$/", $fname)) {
            $errors['fname'] = '❌ Only letters and white space are allowed.';
        } else {
            $data['fname'] = $fname;
        }

        // Last name validation
        if (empty($lname)) {
            $errors['lname'] = '⚠️ Please enter your last name.';
        } elseif (!preg_match("/^[a-zA-Z-' ]*$/", $lname)) {
            $errors['lname'] = '❌ Only letters and white space are allowed.';
        } else {
            $data['lname'] = $lname;
        }

        // Email validation
        if (empty($email)) {
            $errors['email'] = '⚠️ Email address is required.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = '❌ Please enter a valid email address.';
        } else {
            $data['email'] = $email;
        }

        // Password validation
        if (empty($password)) {
            $errors['password'] = '⚠️ Please create a password.';
        } elseif (strlen($password) < 6) {
            $errors['password'] = '❌ Password must be at least 6 characters.';
        } else {
            $data['password'] = $password;
        }
        if (empty($_POST['country'])) {
            $errors['country'] = '⚠️ Please select your country.';
        } else {
            $data['country'] = validation($_POST['country']);
        }


        if (empty($errors)) {
            $success = true;
        }
    }

    function validation($data)
    {
        return htmlspecialchars(stripslashes(trim($data)), ENT_QUOTES, 'UTF-8');
    }
    ?>

    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md">
        <h1 class="text-3xl font-bold text-center text-blue-700 mb-6">Form Validation</h1>

        <?php if ($success): ?>
            <div class="bg-green-100 text-green-700 p-3 mb-4 rounded-lg text-center font-semibold">
                ✅ Form submitted successfully!
            </div>
            <div class="bg-gray-50 p-4 rounded-lg mb-4 text-sm text-gray-700">
                <p><strong>First Name:</strong> <?= $data['fname'] ?></p>
                <p><strong>Last Name:</strong> <?= $data['lname'] ?></p>
                <p><strong>Email:</strong> <?= $data['email'] ?></p>
                <p><strong>Country:</strong> <?= $data['country'] ?></p>
            </div>
        <?php endif; ?>

        <form action="" method="post" class="space-y-5" enctype="multipart/form-data">

            <!-- First Name -->
            <div>
                <input type="text" name="fname" placeholder="Enter First Name"
                    class="w-full border <?= isset($errors['fname']) ? 'border-red-500' : 'border-gray-300' ?> rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    value="<?= $_POST['fname'] ?? '' ?>" />
                <?php if (isset($errors['fname'])): ?>
                    <p class="text-red-500 text-sm mt-1"><?= $errors['fname'] ?></p>
                <?php endif; ?>
            </div>

            <!-- Last Name -->
            <div>
                <input type="text" name="lname" placeholder="Enter Last Name"
                    class="w-full border <?= isset($errors['lname']) ? 'border-red-500' : 'border-gray-300' ?> rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    value="<?= $_POST['lname'] ?? '' ?>" />
                <?php if (isset($errors['lname'])): ?>
                    <p class="text-red-500 text-sm mt-1"><?= $errors['lname'] ?></p>
                <?php endif; ?>
            </div>

            <!-- Email -->
            <div>
                <input type="email" name="email" placeholder="Enter Email"
                    class="w-full border <?= isset($errors['email']) ? 'border-red-500' : 'border-gray-300' ?> rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    value="<?= $_POST['email'] ?? '' ?>" />
                <?php if (isset($errors['email'])): ?>
                    <p class="text-red-500 text-sm mt-1"><?= $errors['email'] ?></p>
                <?php endif; ?>
            </div>
            <!-- Email -->
            <div>

            </div>

            <!-- Password -->
            <div>
                <input type="password" name="password" placeholder="Enter Password"
                    class="w-full border <?= isset($errors['password']) ? 'border-red-500' : 'border-gray-300' ?> rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                <?php if (isset($errors['password'])): ?>
                    <p class="text-red-500 text-sm mt-1"><?= $errors['password'] ?></p>
                <?php endif; ?>
                <div>
                    <label for="country" class="block text-gray-700 font-medium mb-1">Select Your Country</label>
                    <select name="country" id="country"
                        class="w-full border <?= isset($errors['country']) ? 'border-red-500' : 'border-gray-300' ?> rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white">
                        <option value="">-- Choose a country --</option>
                        <option value="Bangladesh" <?= (isset($_POST['country']) && $_POST['country'] == 'Bangladesh') ? 'selected' : '' ?>>Bangladesh</option>
                        <option value="India" <?= (isset($_POST['country']) && $_POST['country'] == 'India') ? 'selected' : '' ?>>India</option>
                        <option value="Pakistan" <?= (isset($_POST['country']) && $_POST['country'] == 'Pakistan') ? 'selected' : '' ?>>Pakistan</option>
                    </select>

                    <?php if (isset($errors['country'])): ?>
                        <p class="text-red-500 text-sm mt-1"><?= $errors['country'] ?></p>
                    <?php endif; ?>
                </div>
                <!-- Gender -->
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Gender</label>
                    <div class="flex items-center space-x-6">
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="gender" value="Male"
                                class="text-blue-600 focus:ring-blue-500 border-gray-300" <?= (($_POST['gender'] ?? '') == 'Male') ? 'checked' : '' ?> />
                            <span>Male</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="gender" value="Female"
                                class="text-pink-600 focus:ring-pink-500 border-gray-300" <?= (($_POST['gender'] ?? '') == 'Female') ? 'checked' : '' ?> />
                            <span>Female</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="gender" value="Other"
                                class="text-purple-600 focus:ring-purple-500 border-gray-300" <?= (($_POST['gender'] ?? '') == 'Other') ? 'checked' : '' ?> />
                            <span>Other</span>
                        </label>
                    </div>
                    <p class="text-red-500 text-sm mt-1"><?= $errors['gender'] ?? '' ?></p>
                </div>
                <!-- File Upload -->
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Upload Profile Picture</label>
                    <input type="file" name="image"
                        class="block w-full text-sm text-gray-700 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />

                    <p class="text-red-500 text-sm mt-1"><?= $errors['imageName'] ?? '' ?></p>
                </div>
                <button type="submit" name="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition duration-200 mt-2">
                    Submit
                </button>
            </div>
        </form>
    </div>
</body>

</html>