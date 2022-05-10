<?php
//Grâce à cette ligne nous avons une gestion stricte des types
declare(strict_types=1);
require_once './system/config.php';

// //--------------ROLES--------------// 

// La classe Role ne va pas avoir vocation à être instanciée nous pouvons donc utiliser une classe abstraite
// Pour indiquer à un classe qu'elle est abstraite on utilise le mot clé abstract

// $db = new PDO("mysql:host=localhost;dbname=demaindeslaube", "root", "");
// $query = $db->query("SELECT * FROM users");
// $users = $query->fetchAll();

abstract class Role
{
    // Constantes de classe
    // Ces constantes sont naturellement statique autrement dit, on fait appel à ces propriétés via la classe et non via une instance de la classe
    const ADMIN = "admin";
    const USER = "user";
    //Lorsque vous voyez la mention static dans la déclaration d'une méthode cela signifie que la méthode est statique et ne pourra étre appelé que via la classe
    public static function getRoles(): array
    {
        // le mot clé self permet de faire référence à la classe courante
        // ne pas confondre avec $this qui fait référence à une instance de la classe
        return array(self::USER, self::ADMIN);
    }
}
//L'utilisation d'une interface permet de lister la déclaration des méthodes à implémenter dans une classe par la suite
interface IUser
{
    public function getFullName(): string;
    public function isAdmin(): bool;
}
// Pour utiliser / implémenter une interface il faut utiliser le mot clé implements
class User implements IUser
{
    //La propriété role ne sera pas accessible via l'instance de la classe User car nous utilisons le mot clé protected
    // Role::USER permet de faire appel à la propriété statique User de la chaine Role
    protected $role = Role::USER;

    public function __construct(string $firstname, string $lastname, string $email)
    {
        // Sans même le préciser firstname,email et lastname ont une visibilitée public
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
    }
    public function getFullName(): string
    {
        return "{$this->firstname} {$this->lastname} {$this->email}";
    }
    // Le mot clé final en préfixe de la déclaration de la méthode indiqque que le méthode ne pourra pas être surchargée dans la ou les classes enfants
    final public function isAdmin(): bool
    {
        return $this->role === Role::ADMIN;
    }
}
//Pour hériter d'une classe on utilise le mot clé extends
class Admin extends User
{
    protected $role = Role::ADMIN;
    //Redefinir un constructeur pour ajouter des propriétés supplémentaires
    public function __construct(string $firstname, string $lastname, string $email, string $controlArea)
    {
        // Appel au constructeur de la classe mère
        parent::__construct($firstname, $lastname, $email);
        $this->controlArea = $controlArea;
    }
    //Redéfinir la méthode n'est pas possible car la méthode de la classe mere dispose du mot clé final qui empéche la surcharge de cette méthode dans une classe enfant
    // public function isAdmin() {}
}

//On crée une instance de la classe User /autrement dit on génére un objet de la classe User

//$db = new PDO("mysql:host=localhost;dbname=demaindeslaube", "root", "");
$queryUser = $db->prepare("SELECT * FROM users WHERE email LIKE :email");
$queryUser->bindparam(":email", $email);
//$queryUser->bindparam(":email", $email);

$user = $queryUser->fetch();
// foreach ($users as $us) {
//     $i=0;
//     $i++;

// $userFound = new User($user["name"], $user["firstname"], $user["email"]);
// }
//var_dump($user);
// $query = $db->query("SELECT * FROM users WHERE role LIKE utilisateur");
// $users = $query->fetchAll();
// foreach ($users as $us) {
//     $user = new User($us["name"], $us["firstname"], $us["email"]);
// }
// // // Pour faire appel a une propriété ou méthode de cet objet on utilise ->
//  echo $user->getFullName();
// //  var_dump($user[$i]->isAdmin());

$query = $db->query("SELECT * FROM users WHERE role LIKE 'admin'");
$admins = $query->fetchAll();
// if ($roles)

foreach ($admins as $ad) {
    $admin = new Admin($ad["firstname"], $ad["name"], $ad["email"], $ad["role"]);
}
//var_dump($admin);
// echo $admin->getFullName();
// // var_dump($admin->isAdmin());
// var_dump($ad["role"]);
// var_dump($us["role"]);
//  var_dump($admin);

// On fait appel à la méthode static getRoles de la classe Role
$roles = Role::getRoles();
//var_dump($roles);





//--------------CONNEXION---------------//

$error = "";
if (!empty($_POST)) {

    $email = trim(strip_tags($_POST["email"]));
    $password = trim(strip_tags($_POST["password"]));

    //  $db = new PDO("mysql:host=localhost;dbname=demaindeslaube", "root", "");
    $query = $db->prepare("SELECT * FROM users WHERE email LIKE :email");
    $query->bindparam(":email", $email);
    $query->execute();
    //PDO::FETCH_ASSOC pr eviter les doublons
    $result = $query->fetch(PDO::FETCH_ASSOC);

    //   if ($password == $result["password"])  pas possible de tester comme ca car nous avons d'un coté une donnée non cryptée et une donnée cryptée
    //  if ($password_hash($password) == $result["password"])  pas possible non plus car la hash généré par password_hash change à chaque appel
    //password_verify va nous permettre de vérifier la correspondance entre le mot de passe saisi et le hash stocké en BDD
    if (!empty($result) && password_verify($password, $result["password"])) {
        // Les informations de connexion sont correctes
        //Démarage du systéme de session 
        session_start();
        // $_SESSION["session_id"] = md5($result["email"]);
        // On stocke le prénom dans une variable de session
        $_SESSION["user"] = $result["firstname"];
        $_SESSION["userName"] = $result["name"];
        $_SESSION["userId"] = $result["id"];
        $_SESSION["userRole"] = $result["role"];
        //On stocke l'adresse ip de l'utilisateur pour palier à une possible attaque "session hijacking"
        $_SESSION["user_ip"] = $_SERVER["REMOTE_ADDR"];
        // var_dump($_SESSION["userRole"]);
        //var_dump($_SESSION);
        if ($result["role"] !== "admin") {
            header("Location: contact.php");
            //  echo "non";
        } else {
            header("Location: my_account.php");
        }
    } else {
        $error = "Impossible de se connecter avec les informations saisies";
    }
}
include("templates/header.php");
?>

<main class="login">

    <div class="flowerPicture"></div>
    <form action="" method="post">
        <h2>Connexion à votre espace utilisateur</h2>

        <div class="form-group">
            <label for="inputEmail">Email :</label>
            <input type="email" name="email" id="inputEmail" required>
        </div>

        <div class="form-group">
            <label for="inputPassword">Mot de passe :</label>
            <input type="password" name="password" id="inputPassword" required>
        </div>

        <div class="error"><?= $error ?></div>
        <input type="submit" value="Se connecter" class="submit">
    </form>

    <div class="bottomLink">
        <a href="reset_password.php">J'ai oublié mon mot de passe</a>
    </div>

</main>

<?php
include("templates/footer.php");
?>