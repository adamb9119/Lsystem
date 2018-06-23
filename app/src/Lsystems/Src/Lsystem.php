<?php
namespace Lsystems\Src;

class Lsystem
{
    protected $axiom;
    protected $rules;
    protected $binds;

    function __construct()
    {
        $this->axiom = "";
        $this->rules = [];
        $this->binds = [];
    }

    public function setBind($key, $do, $param)
    {
        $this->binds[$key] = ['do' => $do, 'param' => $param];
    }

    public function setBinds($array)
    {
        foreach ($array as $key => $bind){
            $this->setBind($key, $bind['value'], $bind['param']);
        }
    }

    public function setAxiom($axiom)
    {
        $this->axiom = $axiom;
    }

    public function addRule($key, $rule)
    {
        $this->rules[$key]=$rule;
    }

    public function addRules($array)
    {
        foreach ($array as $key => $rule){
            $this->addRule($key, $rule);
        }
    }

    protected function generatePath($g)
    {
        $generations = $g;
        $rules       = $this->rules;
        $string      = $this->axiom;

        for ($i = 0; $i < $generations; $i++){
            $string = strtr($string, $rules);
        }

        return $string;
    }

    public function createImage($generation)
    {
        $graphic   = new SvgGraphic();
        $builder    = new SvgBuilder($graphic);
        /**
         * Generuj scieżki
         */
        $path      = $this->generatePath($generation);
        $binds     = $this->binds;

        $builder->newImage('svg-img' . $generation);
        
        /*
         * Przechodzimy po scieżkach i generujemy odpowiedni krok
         */
        for ($i = 0; $i < strlen($path); $i++){
            foreach ($binds as $key => $bind){
                /*
                 * Pobieramy zdefiniowane wartości
                 */
                $do    = $bind['do'];
                $param = $bind['param'];

                if ($path[$i] === $key){
                    if ($do === 'moveForward')
                        $builder->moveForward($param);
                    if ($do === 'moveRight')
                        $builder->moveRight($param);
                    if ($do === 'moveLeft')
                        $builder->moveLeft($param);
                    if ($do === 'savePosition')
                        $builder->savePosition();
                    if ($do === 'restorePosition')
                        $builder->restorePosition();
                }
            }
        }

        $image   = $builder->getImage();
        $imageId = $builder->getImageId();
        $moves   = $builder->getMoves();

        unset($builder);

        return [
            'image'       => $image,
            'id'          => $imageId,
            'moves'       => $moves,
            'source'      => $path
        ];
    }

}
