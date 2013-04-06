<?
include("api.php");
require("Toro.php");

class RootHandler {
    function get() {
      echo "chaMPion API v. 2";
    }
}

class Satisfaction {
    function get($postcode) {
      echo "200";
    }
}

Toro::serve(array(
    "/" => "RootHandler",
    "/getSatisfaction/:alpha" => "Satisfaction",
));
