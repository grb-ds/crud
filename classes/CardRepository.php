<?php


// This class is focussed on dealing with queries for one type of data
// That allows for easier re-using and it's rather easy to find all your queries
// This technique is called the repository pattern
class CardRepository
{
    private $databaseManager;
    private $card;

    // This class needs a database connection to function
    public function __construct(DatabaseManager $databaseManager)
    {
        $this->databaseManager = $databaseManager;
        $this->card = new Card();
    }

    public function create($name, $type, $hp, $stage, $info, $attack)
    {
        echo "Creating";
        $query = "INSERT INTO card (name, type, hp, stage, info, attack) VALUES ('{$name}','{$type}',{$hp},'{$stage}','{$info}','{$attack}')";
        $this->databaseManager->executeQuery($query);
    }

    // Get one
    public function find($id)
    {
        echo "find";
        $query = "SELECT * FROM card WHERE id = {$id}";

        $foundedCard =  $this->databaseManager->executeSelectStatement($query);
        var_dump($foundedCard);

        // TODO: replace dummy data by real one
        return $foundedCard;
    }

    // Get all
    public function get()
    {
        echo "Getting";
        $query = "SELECT * FROM card";

        $cards =  $this->databaseManager->executeSelectStatement($query);
        var_dump($cards);

        // TODO: replace dummy data by real one
        return $cards;

        // We get the database connection first, so we can apply our queries with it
        // return $this->databaseManager->connection-> (runYourQueryHere)
    }

    public function update()
    {
        echo "update";

        $query = "UPDATE card SET ".
            "name = '{$this->card->getName()}', ".
            "type = '{$this->card->getType()}', ".
            "hp = {$this->card->getHp()}, ".
            "stage = '{$this->card->getStage()}', ".
            "info = '{$this->card->getInfo()}', ".
            "attack = '{$this->card->getAttack()}' ".
            "WHERE id = {$this->card->getId()}";

        $this->databaseManager->executeQueryStatement($query);
    }

    public function delete($id)
    {
        echo "delete";
        $query = "DELETE FROM card WHERE id = {$id}";

        $this->databaseManager->executeQueryStatement($query);

    }

    /**
     * @return Card
     */
    public function getCard(): Card
    {
        return $this->card;
    }

    /**
     * @param Card $card
     */
    public function setCard(Card $card): void
    {
        $this->card = $card;
    }

}