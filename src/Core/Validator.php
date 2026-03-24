<?php


namespace App\Core;


use App\Enum\ValidationError;
use Exception;
use InvalidArgumentException;

/**
 * Classe qui valide les donnees
 */
class Validator
{
    /**
     * Donnée à valider
     * @var mixed
     */
    public mixed $data;

    /**
     * Règle de validation, clé = champ et valeur = règles
     * @var array
     */
    public array $rules;

    /**
     * Tableau des erreurs par champ avec type enum
     * @var array
     */
    public array $errors = [];

    /**
     * Tableau des règles validées
     * @var array
     */
    public array $validated = [];


    /**
     * Constructeur
     */
    public function __construct(mixed $data, array $rules)
    {
        $this->data = $data;
        $this->rules = $rules;
    }

    /**
     * Parcourt toutes les règles et applique la validation
     *
     * @return bool
     *
     * @throws Exception
     */
    public function validate() :bool
    {
        $this->errors = [];
        $isValid = true;

        foreach ($this->rules as $field => $ruleString) {
            $value = $this->data[$field] ?? null;
            $rules = explode("|", $ruleString);
//            var_dump($rules);

            # Gestion nullable avec pas de valeur dans le champ
            if(in_array('nullable', $rules,true) && $this->isEmpty($value)){
                continue;
            }

            foreach ($rules as $rule) {
//                var_dump($rule);
//                var_dump($this->applyRule($rule, $field, $value));
                $result = $this->applyRule($rule, $field, $value);
                if(!$result){
                    //var_dump($this->errors);
                    $isValid = false;
                }else{
                    $this->validated[$field] = $value;
                }
            }
        }
//        var_dump($this->getValidated());
        return $isValid;
    }


    /**
     * Traite une règle avec ou sans paramètres
     *
     * @param string $rule Nom de la règle
     * @param string $field Nom du champ
     * @param mixed $value Valeur à valider
     *
     * @return bool
     * @throws Exception
     */
    public function applyRule(string $rule, string $field, mixed $value) : bool
    {
        if(str_contains($rule,':')){
            [$name, $paramString] = explode(':', $rule, 2);
            $params = explode(',', $paramString);
        }else{
            $name = $rule;
            $params = [];
        }

//        var_dump([
//            "name" => $name,
//            "field" => $field,
//            "value" => $value,
//            "params" => $params,
//        ]);


        if(!method_exists($this, $name)){
            throw new Exception("La règle {$name} n'existe pas.");
        }

        $result = $this->$name($value, $field ,$params);

        if (!$result) {
            $this->addError($field, ValidationError::from($name));
        }

        return $result;
    }

    /**
     * Vérifie que la valeur passée soit > min
     *
     * @param mixed $value
     * @param string $field
     * @param array $params
     *
     * @return bool
     * @throws InvalidArgumentException
     */

    public function min(mixed $value, string $field, array $params) : bool
    {
        if (!isset($params[0]) || !is_numeric($params[0])) {
            throw new InvalidArgumentException("La règle min nécessite un paramètre numérique");
        }

        $min = (int)$params[0];
        if (is_string($value)) {
            return mb_strlen($value) >= $min;
        }

        if (is_int($value) || is_float($value)) {
            return $value >= $min;
        }

        if (is_array($value)) {
            return count($value) >= $min;
        }

        return false;
    }

    /**
     * Vérifie que la valeur passée soit < max
     *
     * @param mixed $value
     * @param string $field
     * @param array $params
     *
     * @return bool
     * @throws InvalidArgumentException
     */
    public function max(mixed $value, string $field, array $params) : bool
    {
        if (!isset($params[0]) || !is_numeric($params[0])) {
            throw new InvalidArgumentException("La règle min nécessite un paramètre numérique");
        }

        $max = (int)$params[0];
        if (is_string($value)) {
            return mb_strlen($value) <= $max;
        }

        if (is_int($value) || is_float($value)) {
            return $value <= $max;
        }

        if (is_array($value)) {
            return count($value) <= $max;
        }

        return false;
    }

    /**
     * Vérifie que la valeur soit unique
     *
     * @param mixed $value Valeur à vérifier
     * @param string $field
     * @param array $params [nom_table, champ]
     *
     * @return bool
     * @throws Exception
     */
    public function unique(mixed $value, string $field, array $params) : bool
    {
        if(count($params)<2){
            throw new Exception("unique nécessite [table, colonne]");
        }

        $pdo = Database::getPDO();
        [$nameTable, $champ] = $params;
//        var_dump($sql = "SELECT COUNT(id) FROM {$nameTable} WHERE {$champ} = '{$value}'");
        $sql = "SELECT COUNT(id) FROM {$nameTable} WHERE {$champ} = :value";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(['value'=>$value]);
        $data = $stmt->fetchColumn();
//        var_dump("Data renvoi: " . $data);
        return $data == 0;
    }

    /**
     * Vérifie si un champ peut être vide
     *
     * @param mixed $value
     * @param string $field
     * @param array $params
     *
     * @return bool
     */
    public function nullable(mixed $value, string $field, array $params = []) : bool
    {
        return true;
    }

    /**
     * Vérifie qu'une valeur est présente
     *
     * @param mixed $value
     * @param string $field
     * @param array $params
     *
     * @return bool
     */
    public function required(mixed $value, string $field, array $params = []) : bool
    {
        $isEmpty = $this->isEmpty($value);
        return !$isEmpty;
    }

    /**
     * Vérifie que les valeurs existent dans la table
     *
     * @param mixed $value
     * @param string $field
     * @param array $params
     *
     * @return bool
     * @throws Exception
     */
    public function exists(mixed $value, string $field, array $params) : bool
    {
        if(empty($params)){
            throw new Exception("exists nécessite le nom de la table");
        }
//        var_dump(["params" => $params, "values" => $values]);
        $pdo = Database::getPDO();
        $nameTable = $params[0];

        $sql = "SELECT 1 FROM {$nameTable} WHERE id = :id LIMIT 1";
        $stmt = $pdo->prepare($sql);

        foreach ((array)$value as $id) {
            if(!is_int($id) && !ctype_digit((string) $id)){
                return false;
            }
//                var_dump($value);
//                var_dump($value);
//                var_dump($sql = "SELECT EXISTS(SELECT 1 FROM {$nameTable} WHERE id = :id)");

            $stmt->execute(["id"=>(int) $id]);
            if(!$stmt->fetchColumn()){
                return false;
            }
        }
        return true;

    }

    /**
     * Vérifie si la valeur est considérée comme vide :
     * - string vide
     * - tableau vide
     * - null
     *
     * @param mixed $value
     *
     * @return bool
     */
    public function isEmpty(mixed $value) : bool{
        if(is_string($value))
            return trim($value) === '';

        if(is_array($value))
            return count($value) === 0;

        return $value === null;
    }

    /**
     * Ajoute un message d'erreur pour un champ donné.
     *
     * @param string $field
     * @param ValidationError $rule
     *
     * @return void
     */
    public function addError(string $field, ValidationError $rule ) : void
    {
        $message = $rule->message($field);
        $this->errors[$field][] = [
            'type' => $rule,
            'message' => $message,
        ];
    }

    /**
     * Retourne le tableau des règles validées
     *
     * @return array
     */
    public function getValidated(){
        return $this->validated;
    }

    /**
     * Retourne le tableau des erreurs avec messages
     *
     * @return array
     */
    public function getErrors(){
        return $this->errors;
    }

    /**
     * @return bool
     */
    public function fails(){
        $this->validate();
        return count($this->errors) != 0;
    }

    /**
     * Affiche seulement les règles validées du tableau passé
     *
     * @param array $index
     *
     * @return array
     */
    public function only(array $index) : array{
        $data = [];
        foreach ($this->validated as $field => $value){
            if(in_array($field, $index)){
                $data[]=$value;
            }
        }
//        var_dump($data);
        return $data;
    }

    /**
     * Affiche toutes les règles validées excepté ceux du tableau passé
     *
     * @param array $index
     *
     * @return array
     */
    public function except(array $index) : array{
        $data = [];
        foreach ($this->validated as $field => $value){
            if(!in_array($field, $index)){
                $data[]=$value;
            }
        }
//        var_dump($data);
        return $data;
    }

}
