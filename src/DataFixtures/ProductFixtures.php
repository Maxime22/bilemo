<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProductFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {

        $data = [
            "name" => ['Apple iPhone 12 Pro Max', 'Xiaomi Mi 11 Ultra', 'Samsung Galaxy S21 Ultra', 'Oppo Find X3 Pro', 'Samsung Galaxy S20 Ultra', 'OnePlus 8 Pro', 'Google Pixel 5', 'Xiaomi Mi 10', 'Xiaomi Mi 10T Pro', 'Huawei P30 Pro', 'Huawei Mate 30 Pro'],
            "description" => [
                "Avec son écran bien plus grand, une batterie bien plus dodue et des capacités photo supérieures, l'iPhone 12 Pro Max se pose comme le smartphone d'Apple ultime. À tel point qu'il vient occulter l'iPhone 12 Pro. Finalement, si vous deviez choisir un modèle “pro” cette année, il serait plus sage d'envisager de vous procurer un Pro Max pour tirer profit de tout ce qu'offre Cupertino avec ses modèles 2020, sauf si un smartphone à la taille démesurée vous rebute.",
                "Avec le Mi 11 Ultra, Xiaomi s'offre une vitrine technologique convaincante. Ses performances et son autonomie sont solides, son écran s'avère excellent et il embarque tout ce qu'on attend d'un smartphone ultra haut de gamme en 2021.",
                "Le Samsung Galaxy S21 Ultra est l'un des meilleurs smartphones passés dans nos laboratoires. Sa dalle s'avère de qualité exceptionnelle, ses performances sont compétitives, ses photos de jour très bonnes, et ce S21 Ultra s'avère finalement complet et satisfera tous les besoins.",
                "Si la France du foot attend toujours le nouveau Zidane, le marché des smartphones cherche, lui, le nouveau Huawei. Et Oppo se positionne. S'il est encore loin de proposer un hardware aussi parfait que son controversé compatriote, la filiale de BBK offre un mobile complet et maîtrisé.",
                "Comme chaque fois avec le nouveau haut de gamme de Samsung, nous n'avons pas grand-chose à reprocher à ce Galaxy S20 Ultra. Le fleuron coréen de ce début de décennie collectionne les cinq étoiles pour un sans-faute mérité.",
                "Comme souvent, OnePlus empile avec succès des technologies de pointe, pour nous délivrer un OnePlus 8 Pro très réussi. Dommage que le fleuron chinois ne fasse pas un peu mieux en photo.",
                "Le Pixel 5 n'améliore pas forcément tous les points du Pixel 4, mais il reste un très bon smartphone et offre un parfait équilibre entre performances, endurance et prix.",
                "La recette du Xiaomi Mi 10 fonctionne très bien dans l'ensemble. Le fabricant chinois nous propose un mobile résolument haut de gamme dans son approche, qui n'a que peu de défauts.",
                "Ce Mi 10T Pro est un très bon smartphone, presque excellent. Il reste un bon moyen de mettre un pied dans la 5G.",
                "Année après année, Huawei améliore sa recette et ce P30 Pro en est un bel exemple. De l'écran à la photo — en oubliant l'audio — le mobile photomaniaque ultra-haut de gamme de Huawei est une véritable réussite.",
                "Le Huawei Mate 30 Pro est sans aucun doute l'un des meilleurs smartphones du marché. Techniquement, la promesse d'un mobile haut de gamme, endurant, puissant et excellent en photo est bien tenue."
            ],
            "price" => [1106, 899, 1074.79, 899, 603.16, 506.49, 579, 490, 410.10, 427.80, 590],
            "brand" => ['Apple', 'Xiaomi', 'Samsung', 'Oppo', 'Samsung', 'OnePlus', 'Google', 'Xiaomi', 'Xiaomi', 'Huawei', 'Huawei']

        ];

        for ($i = 0; $i < count($data['name']); $i++) {
            $product = new Product();
            $product->setName($data['name'][$i]);
            $product->setDescription($data['description'][$i]);
            $product->setPrice($data['price'][$i]);
            $product->setBrand($data['brand'][$i]);
            $manager->persist($product);
        }

        $manager->flush();
    }
}
