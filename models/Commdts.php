<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\helpers\VarDumper;

class Commdts extends Model
{
    public array $commodities_arr = [
        'airelics' => 'AI Relics',
        'advancedcatalysers' => 'Advanced Catalysers',
        'advancedmedicines' => 'Advanced Medicines',
        'agriculturalmedicines' => 'Agri-Medicines',
        'agronomictreatment' => 'Agronomic Treatment',
        'alexandrite' => 'Alexandrite',
        'algae' => 'Algae',
        'aluminium' => 'Aluminium',
        'usscargoancientartefact' => 'Ancient Artefact',
        'ancientkey' => 'Ancient Key',
        'animalmeat' => 'Animal Meat',
        'animalmonitors' => 'Animal Monitors',
        'p_particulatesample' => 'Anomaly Particles',
        'antimattercontainmentunit' => 'Antimatter Containment Unit',
        'antiquejewellery' => 'Antique Jewellery',
        'antiquities' => 'Antiquities',
        'aquaponicsystems' => 'Aquaponic Systems',
        'articulationmotors' => 'Articulation Motors',
        'assaultplans' => 'Assault Plans',
        'atmosphericextractors' => 'Atmospheric Processors',
        'autofabricators' => 'Auto-Fabricators',
        'basicmedicines' => 'Basic Medicines',
        'battleweapons' => 'Battle Weapons',
        'bauxite' => 'Bauxite',
        'beer' => 'Beer',
        'benitoite' => 'Benitoite',
        'bertrandite' => 'Bertrandite',
        'beryllium' => 'Beryllium',
        'bioreducinglichen' => 'Bioreducing Lichen',
        'biowaste' => 'Biowaste',
        'bismuth' => 'Bismuth',
        'usscargoblackbox' => 'Black Box',
        'bootlegliquor' => 'Bootleg Liquor',
        'bromellite' => 'Bromellite',
        'buildingfabricators' => 'Building Fabricators',
        'cmmcomposite' => 'CMM Composite',
        'thargoidgeneratortissuesample' => 'Caustic Tissue Sample',
        'ceramiccomposites' => 'Ceramic Composites',
        'chemicalwaste' => 'Chemical Waste',
        'clothing' => 'Clothing',
        'cobalt' => 'Cobalt',
        'coffee' => 'Coffee',
        'coltan' => 'Coltan',
        'combatstabilisers' => 'Combat Stabilisers',
        'comercialsamples' => 'Commercial Samples',
        'computercomponents' => 'Computer Components',
        'conductivefabrics' => 'Conductive Fabrics',
        'consumertechnology' => 'Consumer Technology',
        'copper' => 'Copper',
        'cropharvesters' => 'Crop Harvesters',
        'cryolite' => 'Cryolite',
        'damagedescapepod' => 'Damaged Escape Pod',
        'datacore' => 'Data Core',
        'diplomaticbag' => 'Diplomatic Bag',
        'domesticappliances' => 'Domestic Appliances',
        'earthrelics' => 'Earth Relics',
        'emergencypowercells' => 'Emergency Power Cells',
        'encryptedcorrespondence' => 'Encrypted Correspondence',
        'encripteddatastorage' => 'Encrypted Data Storage',
        'powergridassembly' => 'Energy Grid Assembly',
        'evacuationshelter' => 'Evacuation Shelter',
        'exhaustmanifold' => 'Exhaust Manifold',
        'usscargoexperimentalchemicals' => 'Experimental Chemicals',
        'explosives' => 'Explosives',
        'fish' => 'Fish',
        'foodcartridges' => 'Food Cartridges',
        'fossilremnants' => 'Fossil Remnants',
        'fruitandvegetables' => 'Fruit and Vegetables',
        'gallite' => 'Gallite',
        'gallium' => 'Gallium',
        'genebank' => 'Gene Bank',
        'geologicalequipment' => 'Geological Equipment',
        'geologicalsamples' => 'Geological Samples',
        'gold' => 'Gold',
        'goslarite' => 'Goslarite',
        'grain' => 'Grain',
        'grandidierite' => 'Grandidierite',
        'ancientcasket' => 'Guardian Casket',
        'ancientorb' => 'Guardian Orb',
        'ancientrelic' => 'Guardian Relic',
        'ancienttablet' => 'Guardian Tablet',
        'ancienttotem' => 'Guardian Totem',
        'ancienturn' => 'Guardian Urn',
        'hazardousenvironmentsuits' => 'H.E. Suits',
        'hnshockmount' => 'HN Shock Mount',
        'hafnium178' => 'Hafnium 178',
        'diagnosticsensor' => 'Hardware Diagnostic Sensor',
        'heatsinkinterlink' => 'Heatsink Interlink',
        'hostage' => 'Hostages',
        'hydrogenfuel' => 'Hydrogen Fuel',
        'hydrogenperoxide' => 'Hydrogen Peroxide',
        'imperialslaves' => 'Imperial Slaves',
        'indite' => 'Indite',
        'indium' => 'Indium',
        'insulatingmembrane' => 'Insulating Membrane',
        'iondistributor' => 'Ion Distributor',
        'jadeite' => 'Jadeite',
        'terrainenrichmentsystems' => 'Land Enrichment Systems',
        'landmines' => 'Landmines',
        'lanthanum' => 'Lanthanum',
        'largeexplorationdatacash' => 'Large Survey Data Cache',
        'leather' => 'Leather',
        'lepidolite' => 'Lepidolite',
        'drones' => 'Limpets',
        'liquidoxygen' => 'Liquid oxygen',
        'liquor' => 'Liquor',
        'lithium' => 'Lithium',
        'lithiumhydroxide' => 'Lithium Hydroxide',
        'lowtemperaturediamond' => 'Low Temperature Diamonds',
        'magneticemittercoil' => 'Magnetic Emitter Coil',
        'marinesupplies' => 'Marine Equipment',
        'medicaldiagnosticequipment' => 'Medical Diagnostic Equipment',
        'metaalloys' => 'Meta-Alloys',
        'methaneclathrate' => 'Methane Clathrate',
        'methanolmonohydratecrystals' => 'Methanol Monohydrate Crystals',
        'microcontrollers' => 'Micro Controllers',
        'coolinghoses' => 'Micro-weave Cooling Hoses',
        'heliostaticfurnaces' => 'Microbial Furnaces',
        'militarygradefabrics' => 'Military Grade Fabrics',
        'militaryintelligence' => 'Military Intelligence',
        'usscargomilitaryplans' => 'Military Plans',
        'mineralextractors' => 'Mineral Extractors',
        'mineraloil' => 'Mineral Oil',
        'modularterminals' => 'Modular Terminals',
        'moissanite' => 'Moissanite',
        'm_tissuesample_nerves' => 'Mollusc Brain Tissue',
        'm_tissuesample_fluid' => 'Mollusc Fluid',
        'm3_tissuesample_membrane' => 'Mollusc Membrane',
        'm3_tissuesample_mycelium' => 'Mollusc Mycelium',
        'm_tissuesample_soft' => 'Mollusc Soft Tissue',
        'm3_tissuesample_spores' => 'Mollusc Spores',
        'monazite' => 'Monazite',
        'mutomimager' => 'Muon Imager',
        'musgravite' => 'Musgravite',
        'mysteriousidol' => 'Mysterious Idol',
        'nanobreakers' => 'Nanobreakers',
        'basicnarcotics' => 'Narcotics',
        'naturalfabrics' => 'Natural Fabrics',
        'neofabricinsulation' => 'Neofabric Insulation',
        'nerveagents' => 'Nerve Agents',
        'nonlethalweapons' => 'Non-Lethal Weapons',
        'occupiedcryopod' => 'Occupied Escape Pod',
        'onionheadc' => 'Onionhead Gamma Strain',
        'osmium' => 'Osmium',
        'painite' => 'Painite',
        'palladium' => 'Palladium',
        'performanceenhancers' => 'Performance Enhancers',
        'personaleffects' => 'Personal Effects',
        'personalweapons' => 'Personal Weapons',
        'pesticides' => 'Pesticides',
        'platinum' => 'Platinum',
        's_tissuesample_cells' => 'Pod Core Tissue',
        's_tissuesample_surface' => 'Pod Dead Tissue',
        's6_tissuesample_mesoglea' => 'Pod Mesoglea',
        's6_tissuesample_cells' => 'Pod Outer Tissue',
        's6_tissuesample_coenosarc' => 'Pod Shell Tissue',
        's_tissuesample_core' => 'Pod Surface Tissue',
        's9_tissuesample_shell' => 'Pod Tissue',
        'politicalprisoner' => 'Political Prisoners',
        'polymers' => 'Polymers',
        'powerconverter' => 'Power Converter',
        'powergenerators' => 'Power Generators',
        'powertransferconduits' => 'Power Transfer Bus',
        'praseodymium' => 'Praseodymium',
        'preciousgems' => 'Precious Gems',
        'progenitorcells' => 'Progenitor Cells',
        'prohibitedresearchmaterials' => 'Prohibited Research Materials',
        'usscargoprototypetech' => 'Prototype Tech',
        'pyrophyllite' => 'Pyrophyllite',
        'radiationbaffle' => 'Radiation Baffle',
        'usscargorareartwork' => 'Rare Artwork',
        'reactivearmour' => 'Reactive Armour',
        'usscargorebeltransmissions' => 'Rebel Transmissions',
        'reinforcedmountingplate' => 'Reinforced Mounting Plate',
        'resonatingseparators' => 'Resonating Separators',
        'rhodplumsite' => 'Rhodplumsite',
        'robotics' => 'Robotics',
        'rockforthfertiliser' => 'Rockforth Fertiliser',
        'rutile' => 'Rutile',
        'sap8corecontainer' => 'SAP 8 Core Container',
        'samarium' => 'Samarium',
        'scientificresearch' => 'Scientific Research',
        'scientificsamples' => 'Scientific Samples',
        'scrap' => 'Scrap',
        'semiconductors' => 'Semiconductors',
        'serendibite' => 'Serendibite',
        'silver' => 'Silver',
        'skimercomponents' => 'Skimmer Components',
        'slaves' => 'Slaves',
        'smallexplorationdatacash' => 'Small Survey Data Cache',
        'spacepioneerrelics' => 'Space Pioneer Relics',
        'structuralregulators' => 'Structural Regulators',
        'superconductors' => 'Superconductors',
        'surfacestabilisers' => 'Surface Stabilisers',
        'survivalequipment' => 'Survival Equipment',
        'syntheticfabrics' => 'Synthetic Fabrics',
        'syntheticmeat' => 'Synthetic Meat',
        'syntheticreagents' => 'Synthetic Reagents',
        'taaffeite' => 'Taaffeite',
        'tacticaldata' => 'Tactical Data',
        'tantalum' => 'Tantalum',
        'tea' => 'Tea',
        'usscargotechnicalblueprints' => 'Technical Blueprints',
        'telemetrysuite' => 'Telemetry Suite',
        'thallium' => 'Thallium',
        'thargoidtissuesampletype2' => 'Thargoid Basilisk Tissue Sample',
        'unknownbiologicalmatter' => 'Thargoid Biological Matter',
        'thargoidtissuesampletype1' => 'Thargoid Cyclops Tissue Sample',
        'thargoidtissuesampletype6' => 'Thargoid Glaive Tissue Sample',
        'thargoidheart' => 'Thargoid Heart',
        'thargoidtissuesampletype4' => 'Thargoid Hydra Tissue Sample',
        'unknownartifact3' => 'Thargoid Link',
        'thargoidtissuesampletype3' => 'Thargoid Medusa Tissue Sample',
        'thargoidtissuesampletype5' => 'Thargoid Orthrus Tissue Sample',
        'unknownartifact2' => 'Thargoid Probe',
        'unknownresin' => 'Thargoid Resin',
        'thargoidscouttissuesample' => 'Thargoid Scout Tissue Sample',
        'unknownartifact' => 'Thargoid Sensor',
        'unknowntechnologysamples' => 'Thargoid Technology Samples',
        'thermalcoolingunits' => 'Thermal Cooling Units',
        'thorium' => 'Thorium',
        'timecapsule' => 'ControllerHelper Capsule',
        'thargoidtissuesampletype9a' => 'Titan Deep Tissue Sample',
        'thargoidtissuesampletype10a' => 'Titan Maw Deep Tissue Sample',
        'thargoidtissuesampletype10c' => 'Titan Maw Partial Tissue Sample',
        'thargoidtissuesampletype10b' => 'Titan Maw Tissue Sample',
        'thargoidtissuesampletype9c' => 'Titan Partial Tissue Sample',
        'thargoidtissuesampletype9b' => 'Titan Tissue Sample',
        'titanium' => 'Titanium',
        'tobacco' => 'Tobacco',
        'toxicwaste' => 'Toxic Waste',
        'usscargotradedata' => 'Trade Data',
        'trinketsoffortune' => 'Trinkets of Hidden Fortune',
        'tritium' => 'Tritium',
        'ancientrelictg' => 'Unclassified Relic',
        'unocuppiedescapepod' => 'Unoccupied Escape Pod',
        'unstabledatacore' => 'Unstable Data Core',
        'uraninite' => 'Uraninite',
        'uranium' => 'Uranium',
        'opal' => 'Void Opal',
        'water' => 'Water',
        'waterpurifiers' => 'Water Purifiers',
        'wine' => 'Wine',
        'wreckagecomponents' => 'Wreckage Components',
    ];
    public array $landig_pad_sizes = [
        'Ocellus Starport' => 'L',
        'Orbis Starport' => 'L',
        'Outpost' => 'M',
        'Coriolis Starport' => 'L',
        'Planetary Outpost' => 'L',
        'Asteroid base' => 'L',
        'Planetary Port' => 'L',
        'Mega ship' => 'L',
        'Fleet Carrier' => 'L',
        'Odyssey Settlement' => 'S or L',
    ];

    public function getPrices($sys_name, $commodities): ActiveDataProvider
    {
        $ref_xyz = $this->getCoords($sys_name);

        $c_symbols = [];

        foreach ($this->commodities_arr as $key => $value) {
            if (in_array($value, $commodities)) {
                $c_symbols[] = $key;
            }
        }

        $prices = (new Query())
            ->select([
                'buy_price',
                'demand',
                'sell_price',
                'stock',
                'm.name AS commodity',
                'st.name AS station',
                'type',
                'distance_to_arrival AS distance_ls',
                'sys.name AS system',
                "ROUND(SQRT(POW((sys.x - {$ref_xyz['x']}), 2) + POW((sys.y - {$ref_xyz['y']}), 2) + 
                POW((sys.z - {$ref_xyz['z']}), 2)), 2) AS distance_ly",
                'timestamp'
            ])
            ->from(['m' => 'markets'])
            ->innerJoin(['st' => 'stations'], 'm.market_id = st.market_id')
            ->innerJoin(['sys' => 'systems'], 'st.system_id = sys.id')
            ->where(['m.name' => $c_symbols])
            ->andWhere([
                '<=',
                "ROUND(SQRT(POW((sys.x - {$ref_xyz['x']}), 2) + POW((sys.y - {$ref_xyz['y']}), 2) + 
                POW((sys.z - {$ref_xyz['z']}), 2)), 2)",
                50,
            ]);

        return  new ActiveDataProvider(config: [
            'query' => $prices,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'attributes' => [
                    'distance_ly'
                ],
                'defaultOrder' => [
                        'distance_ly' => SORT_DESC,
                ],
            ]
        ]);
    }

    public function modifyModels($models): array
    {
        foreach ($models as $key => $value) {
        }
        return [];
    }

    public function getMarketItem($sys_name, $st_name): array
    {
        return  (new Query())
            ->select([
                'buy_price',
                'demand',
                'sell_price',
                'mean_price',
                'stock',
                'm.name AS commodity',
                'st.name AS station',
                'type',
                'st.distance_to_arrival AS distance_ls',
                'sys.name AS system',
                'timestamp'
            ])
            ->from(['m' => 'markets'])
            ->innerJoin(['st' => 'stations'], 'm.market_id = st.market_id')
            ->innerJoin(['sys' => 'systems'], 'st.system_id = sys.id')
            ->where(['sys.name' => $sys_name])
            ->andWhere(['st.name' => $st_name])
            ->one();
    }

    public function getCoords($sys_name): array
    {
        return Systems::find()
            ->select(['x', 'y', 'z'])
            ->where(['name' => $sys_name])
            ->asArray()
            ->one();
    }
}
