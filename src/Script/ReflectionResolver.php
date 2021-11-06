<?php

namespace CommissionTask\Script;

class ReflectionResolver
{
    public function resolve(string $class)
    {
        try {
            $reflectionClass = new \ReflectionClass($class);

            if( ! $reflectionClass->isInstantiable())
            {
                throw new \Exception("[$class] is not instantiable");
            }

            if (($constructor = $reflectionClass->getConstructor()) === null) {
                return $reflectionClass->newInstance();
            }

            if (($params = $constructor->getParameters()) === []) {
                return $reflectionClass->newInstance();
            }

            $newInstanceParams = $this->getDependencies($params);

            return $reflectionClass->newInstanceArgs(
                $newInstanceParams
            );
        }
        catch (\Exception $e)
        {
            echo $e->getMessage();
        }
    }

    public function getDependencies($params)
    {
        $dependencies = [];

        foreach ($params as $param) {
            $dependencies[] = $param->getClass() === null ? $param->getDefaultValue() : $this->resolve(
                $param->getClass()->getName()
            );
        }

        return $dependencies;
    }

}