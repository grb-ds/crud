<?php

// Require the correct variable type to be used (no auto-converting)
declare (strict_types = 1);

// Show errors so we get helpful information
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Load you classes
require_once 'config.php';
require_once 'classes/DatabaseManager.php';
require_once 'classes/CardRepository.php';
require_once "classes/Card.php";

$databaseManager = new DatabaseManager($config['host'], $config['user'], $config['password'], $config['dbname']);
$databaseManager->connect();

// This example is about a Pokémon card collection
// Update the naming if you'd like to work with another collection
$cardRepository = new CardRepository($databaseManager);
$cards = $cardRepository->get();

if (isset($_POST["add"])) {
    $name = $_POST["name"];
    $type = $_POST["type"];
    $hp = (int) $_POST["hp"];
    $stage = $_POST["stage"];
    $info = $_POST["info"];
    $attack = $_POST["attack"];
    $cardRepository->create($name, $type, $hp, $stage, $info, $attack);
    $cards = $cardRepository->get();
}

if (isset($_POST["editCard"])) {
    $cardArray = $cardRepository->find((int)$_POST["editCard"]);
    $foundedCard = $cardRepository->getCard();
    $foundedCard->setId($cardArray[0]['id']);
    $foundedCard->setName($cardArray[0]['name']);
    $foundedCard->setType($cardArray[0]['type']);
    $foundedCard->setHp($cardArray[0]['hp']);
    $foundedCard->setStage($cardArray[0]['stage']);
    $foundedCard->setInfo($cardArray[0]['info']);
    $foundedCard->setAttack($cardArray[0]['attack']);
    $cardRepository->setCard($foundedCard);
    var_dump($cardRepository->getCard());
}

if (isset($_POST["edit"])) {
    $card = new Card();
    $card->setId((int) $_POST["edit"]);
    $card->setName($_POST["name"]);
    $card->setType($_POST["type"]);
    $card->setHp((int) $_POST["hp"]);
    $card->setStage($_POST["stage"]);
    $card->setInfo($_POST["info"]);
    $card->setAttack($_POST["attack"]);
    $cardRepository->setCard($card);
    $cardRepository->update();
    $cards = $cardRepository->get();
}


if (isset($_POST["deleteCard"])) {
    $cardRepository->delete((int)$_POST["deleteCard"]);
    $cards = $cardRepository->get();
    var_dump($cardRepository->getCard());
}


// Load your view
// Tip: you can load this dynamically and based on a variable, if you want to load another view
require 'overview.php';