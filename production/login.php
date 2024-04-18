<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Barbierplaner</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <link rel="stylesheet" href="login.css">
    </head>
    <body>
        <body>
            <div class="container" id="container">
                <div class="form-container sign-up">
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <h1>Account Erstellen</h1>
                        <div class="social-icons">
                            <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                            <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                            <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                        </div>
                        <span>oder benutzen Sie eine E-Mail zum Anmelden</span>
                        <input type="text" placeholder="Name" name="name" required>
                        <input type="email" placeholder="Email" name="email" required>
                        <input type="password" placeholder="Password" name="password" required>
                        <input type="hidden" name="formtype" value="register">
                        <button type="submit">Sign Up</button>
                    </form>
                </div>
                <div class="form-container sign-in">
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <h1>Anmelden</h1>
                        <div class="social-icons">
                            <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                            <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                            <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                        </div>
                        <span>oder benutzen Sie eine E-Mail</span>
                        <input type="email" placeholder="Email" name="email" required>
                        <input type="password" placeholder="Password" name="password" required>
                        <input type="hidden" name="formtype" value="login">
                        <a href="#">Forget Your Password?</a>
                        <button type="submit">Sign In</button>
                    </form>
                </div>
                <div class="toggle-container">
                    <div class="toggle">
                        <div class="toggle-panel toggle-left">
                            <h1>Wilkommen Zurück!</h1>
                            <p>Geben Sie ihre Daten an, um auf alle Features zuzugreifen</p>
                            <button class="hidden" id="login">Sign In</button>
                        </div>
                        <div class="toggle-panel toggle-right">
                            <h1>Hallo, Liebe Kunden!</h1>
                            <p>Melden Sie sich an, um Heute noch ein Termin zu vereinbaren</p>
                            <button class="hidden" id="register">Sign Up</button>
                        </div>
                    </div>
                </div>
            </div>
        <script src="login.js"></script>
    </body>
</html>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "websitelogin";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Register User
        if (isset($_POST['formtype']) && $_POST['formtype'] == 'register') {
            if (isset($_POST['name'])) {
                $name = $_POST['name'];

                $sql = "INSERT INTO logindetails (name, email, password) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sss", $name, $email, $password);
                $stmt->execute();

                echo "Erfolgreich registriert! Sie können sich jetzt Anmelden.";
            }
        }
        // Login User
        elseif (isset($_POST['formtype']) && $_POST['formtype'] == 'login') {

            $sql = "SELECT * FROM logindetails WHERE email = ? AND password = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $email, $password);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                header ('Location: kalender.html');
            } else {
                echo "Ungültige E-Mail oder Passwort. Versuchen Sie es erneut.";
            }
        }
    }
}
?>
