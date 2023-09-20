<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require './vendor/phpmailer/phpmailer/src/Exception.php';
require './vendor/phpmailer/phpmailer/src/PHPMailer.php';
require './vendor/phpmailer/phpmailer/src/SMTP.php';
require './vendor/autoload.php';

$filename = './sources/css/style.css';
$filename_update = filemtime($filename);

// form validation
$validation_success = true;
if (isset($_POST['name'])) {
    $name = $_POST['name'];
    if (!ctype_alnum($name)) {
        $validation_success = false;
        $error_name = "Only letters and numbers (without special characters)";
    }

    if (isset($_POST['email'])) {
        $email = $_POST['email'];
        $email_sanitize = filter_var($email, FILTER_SANITIZE_EMAIL);
        if (!filter_var($email_sanitize, FILTER_VALIDATE_EMAIL) || $email != $email_sanitize) {
            $validation_success = false;
            $error_email = "Incorrect email";
        };
    };

    $message = isset($_POST['message']) ? $_POST['message'] : '';
    $website = isset($_POST['website']) ? $_POST['website'] : '';
    $github = isset($_POST['github']) ? $_POST['github'] : '';

    // send email
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    try {
        if ($validation_success === true) {
            //credentials
            $credentials = require './sources/php/credentials.php';
            //Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;             //Enable verbose debug output
            $mail->isSMTP();                                      //Send using SMTP
            $mail->Host       = $credentials['host'];             //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                             //Enable SMTP authentication
            $mail->Username   = $credentials['username'];         //SMTP username
            $mail->Password   = $credentials['password'];         //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;      //Enable implicit TLS encryption
            $mail->Port       = 465;                              //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom($credentials['to'], 'Me');             //Use an address in your own domain as the from address, put the submitter's address in a reply-to
            $mail->addAddress($credentials['to']);                //Add a recipient
            $mail->addReplyTo($email, $name);

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Message from portfolio site';
            $mail->Body    = "<b>Message from:</b> $name (email: $email) <br> <b>Message:</b> $message";
            $mail->AltBody = $message;

            $mail->send();
            $message_status = 'ok';
            $message_info = 'Message has been sent <i class="fa fa-check" aria-hidden="true"></i>';
            unset($validation_succes);
        } else {
            unset($validation_succes);
        };
    } catch (Exception $e) {
        unset($validation_succes);
        $message_status = 'error';
        $message_info = '<i class="fa-solid fa-xmark"></i> Message could not be sent.';
        // $message_info = '<i class="fa-solid fa-xmark"></i>' . " Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    };
};
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Fontawesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?php echo $filename; ?>?v=<?php echo $filename_update; ?>">
    <link rel="shortcut icon" href="./images/code-solid.svg" type="image/x-icon">
    <title>Modern Web Sites</title>
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="menu-overlay"></div>
        <a href=""><i class="fa-solid fa-code fa-5x"></i></a>
        <ul class="menu">
            <li data-key="hero" class="menu-link active">home</li>
            <li data-key="projects" class="menu-link">projects</li>
            <li data-key="aboutme" class="menu-link">about me</li>
            <!-- <li data-key="blog" class="menu-link">blog</li> -->
            <li data-key="contact" class="menu-link">contact</li>
        </ul>
        <i class="fa-solid fa-xmark hamburger"></i>
        <i class="fa-solid fa-bars hamburger"></i>
    </nav>
    <!-- HERO -->
    <section class="hero">
        <div class="hero-info">
            <h1>frontend developer</h1>
            <p>Modern web application</p>
            <div class="hero-contact">
                <i class="fa-brands fa-linkedin fa-4x"></i>
                <i class="fa-brands fa-github fa-4x"></i>
            </div>
        </div>
        <div class="slider">
            <img class="slide" src="./images/projects/first-project.jpg" alt="">
            <img class="slide" src="./images/projects/second-project.jpg" alt="">
            <img class="slide" src="./images/projects/third-project.jpg" alt="">
            <div class="dots">
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
            </div>
        </div>
    </section>
    <!-- PROJECTS -->
    <section class="projects">
        <h1>projects</h1>
        <div class="projects-gallery">
            <div class="single-project" data-project="1">
                <img src="./images/projects/first-project.jpg" alt="Simple online store">
                <h3 id="title">Leather goods store</h3>
                <p id="descr">Simple online store with leather goods. Created mostly with Vanilla JavaScript. It has basic features like shopping cart, products gallery, search bar and contact form. Used techologies below.</p>
                <h3>Technologies</h3>
                <div class="techs">
                    <span class="icon-hover" data-hover="HTML"><i class="fa-brands fa-html5"></i></span>
                    <span class="icon-hover" data-hover="CSS"><i class="fa-brands fa-css3-alt"></i></span>
                    <span class="icon-hover" data-hover="JavaScript"><i class="fa-brands fa-square-js"></i></span>
                    <span class="icon-hover" data-hover="PHP"><i class="fa-brands fa-php"></i></span>
                    <span class="icon-hover" data-hover="MySQL"><i class="fa-solid fa-database"></i></span>
                </div>
            </div>
            <div class="single-project" data-project="2">
                <img src="./images/projects/second-project.jpg" alt="Symfony todo list">
                <h3 id="title">Symfony TODO app</h3>
                <p id="descr">Simple TODO app created mostly with Symfony framework. You can organize your lists and tasks. It contains register and form. This was one of the recruitment tasks. Used technologies below.</p>
                <h3>Technologies</h3>
                <div class="techs">
                    <span class="icon-hover" data-hover="Symfony"><i class="fa-brands fa-symfony"></i></span>
                    <span class="icon-hover" data-hover="PHP"><i class="fa-brands fa-php"></i></span>
                    <span class="icon-hover" data-hover="Bootstrap"><i class="fa-brands fa-bootstrap"></i></span>
                </div>
            </div>
            <div class="single-project" data-project="3">
                <img src="./images/projects/third-project.jpg" alt="Bootstrap layout">
                <h3 id="title">Bootstrap layout</h3>
                <p id="descr">Business site for gardening company. Created mostly with Bootstrap and scaled for mobile devices. This was one of the recruitment tasks. Used technologies below.</p>
                <h3>Technologies</h3>
                <div class="techs">
                    <span class="icon-hover" data-hover="HTML"><i class="fa-brands fa-html5"></i></span>
                    <span class="icon-hover" data-hover="PHP"><i class="fa-brands fa-php"></i></span>
                    <span class="icon-hover" data-hover="Bootstrap"><i class="fa-brands fa-bootstrap"></i></span>
                    <span class="icon-hover" data-hover="CSS"><i class="fa-brands fa-css3-alt"></i></span>
                </div>
            </div>
        </div>
        <!-- single project modal -->
        <div class="modal-overlay ">
            <!-- <div class="project-modal">
                <img src="" alt=" project details">
                <div class="project-info">
                    <i class="fa-solid fa-xmark modal"></i>
                    <h3>${title}</h3>
                    <p>${descr}</p>
                    <h3>Technologies</h3>
                    <div class="techs"></div>
                    <div class="links">
                        <a class="demo" href="" target="_blank">Live demo</a>
                        <a class="github" href="https://github.com/PyCoderPL" target="_blank"><i class="fa-brands fa-github fa-2x"></i></a>
                    </div>
                </div>
            </div> -->
        </div>
    </section>
    <!-- ABOUT ME -->
    <section class="aboutme">
        <h1>about me</h1>
        <div class="aboutme-container">
            <img src="./images/about.jpg" alt="">
            <div class="story">
                <h2>hi, my name is <span>martin</span></h2>
                <p>I am a Self-Taught web developer who started web development journey almost one year ago. Currently I open to interesting projects in which I will be able to show my creativity, face challenges and develop my skills to become a professional programmer.</p>
                <div class="knowhow">
                    <div>
                        <h3>Technologies</h3>
                        <span class="icon-hover" data-hover="HTML"><i class="fa-brands fa-html5"></i></span>
                        <span class="icon-hover" data-hover="CSS"><i class="fa-brands fa-css3-alt"></i></span>
                        <span class="icon-hover" data-hover="JavaScript"><i class="fa-brands fa-square-js"></i></span>
                        <span class="icon-hover" data-hover="PHP"><i class="fa-brands fa-php"></i></span>
                        <span class="icon-hover" data-hover="MySQL"><i class="fa-solid fa-database"></i></span>
                        <span class="icon-hover" data-hover="Git"><i class="fa-brands fa-git"></i></span>
                    </div>
                    <div>
                        <h3>Frameworks</h3>
                        <span class="icon-hover" data-hover="Symfony"><i class="fa-brands fa-symfony" data-hover="Symfony"></i></span>
                        <span class="icon-hover" data-hover="Bootstrap"><i class="fa-brands fa-bootstrap" data-hover="Bootstrap"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- BLOG -->
    <!-- <section class="blog">
        <h1>blog</h1>
    </section> -->
    <!-- CONTACT -->
    <div class="message-status <?php echo $message_status; ?>"><?php echo $message_info; ?></div>
    <section class="contact" id="contact">
        <h1>contact</h1>
        <div class="contact-container">
            <div class="contact-info">
                <p>If you have any questions, please feel free to contact with me.</p>
                <div>
                    <a href="https://github.com/PyCoderPL"><i class="fa-regular fa-envelope fa-2x"></i></a>
                    <a href="https://github.com/PyCoderPL"><i class="fa-brands fa-linkedin fa-2x"></i></a>
                    <a href="https://github.com/PyCoderPL" target="_blank"><i class="fa-brands fa-github fa-2x"></i></a>
                </div>
            </div>
            <form method="post">
                <input type="text" placeholder="name" name="name" required <?php if (isset($error_name)) echo 'autofocus'; ?>>
                <div class="<?php if (isset($error_name)) echo 'error'; ?>"><?php if (isset($error_name)) echo $error_name; ?></div>
                <input type="text" placeholder="email" name="email" required <?php if (isset($error_email)) echo 'autofocus'; ?>>
                <div class="<?php if (isset($error_email)) echo 'error'; ?>"><?php if (isset($error_email)) echo $error_email; ?></div>
                <input type="text" placeholder="github (optional)" name="github">
                <input type="text" placeholder="website (optional)" name="website">
                <textarea cols="" rows="50" placeholder="your message" name="message" required></textarea>
                <input type="submit" value="send">
            </form>
        </div>
    </section>
    <?php
    unset($message_status);
    unset($message_info);
    unset($error_name);
    unset($error_email);
    ?>
    <section class="footer">
        <div class="footer-menu">
            <ul class="footer-links">
                <li><a href="#contact">contact</a></li>
                <li><a href="#">instagram</a></li>
                <li><a href="#">facebook</a></li>
                <li><a href="#">linkedin</a></li>
            </ul>
            <p class="email">frontend.developer@mail.com</p>
        </div>
        <div class="footer-rights">
            <p>Copyright &copy 2023</p>
            <p>made by <span>em web design</span></p>
        </div>
    </section>
    <script src="./sources/js/index.js" defer></script>
</body>

</html>