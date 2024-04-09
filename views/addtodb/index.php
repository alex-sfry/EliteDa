<?php

use yii\helpers\VarDumper;

$this->title = 'Add to DB';
?>
<main class="flex-grow-1 mb-4 bg-main-background align-items-center h-100">
    <div class="container-xxl px-3 align-items-center h-100">
        <div class="row justify-content-center align-items-center h-100">
            <div class="col-lg-5 align-items-center">
                <div class="bg-light p-3 rounded-2 sintony-reg" style="width: fit-content">
                    <div class="d-flex align-items-center column-gap-2">
                        <label for="materialsTbl">Materials</label>
                        <button id="addMaterials" class="btn btn-primary btn-sm">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<div id="encoded" class="d-none">
    <h2>Encoded materials</h2>
    <table class="article-table article-table-selected sortable jquery-tablesorter">
        <thead>
            <tr>
                <th scope="col" class="headerSort" tabindex="0" role="columnheader button" title="Sort ascending">
                    Name
                </th>
                <th scope="col" class="headerSort" tabindex="0" role="columnheader button" title="Sort ascending">
                    Category
                </th>
                <th scope="col" class="headerSort" tabindex="0" role="columnheader button" title="Sort ascending">
                    Grade
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>
                    <a href="/wiki/Aberrant_Shield_Pattern_Analysis"
                       title="Aberrant Shield Pattern Analysis">Aberrant Shield Pattern Analysis
                    </a>
                </th>
                <td data-sort-value="3">Shield Data
                </td>
                <td data-sort-value="4">
                    <a href="/wiki/Category:Rare_materials" title="Category:Rare materials">Rare</a>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Abnormal_Compact_Emissions_Data"
                       title="Abnormal Compact Emissions Data">Abnormal Compact Emissions Data
                    </a>
                </th>
                <td data-sort-value="1">Emission Data
                </td>
                <td data-sort-value="5">
                    <a href="/wiki/Category:Very_rare_materials" title="Category:Very rare materials">Very Rare</a>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Adaptive_Encryptors_Capture"
                       title="Adaptive Encryptors Capture">Adaptive Encryptors Capture
                    </a>
                </th>
                <td data-sort-value="4">Encryption Files
                </td>
                <td data-sort-value="5">
                    <a href="/wiki/Category:Very_rare_materials" title="Category:Very rare materials">Very Rare</a>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Anomalous_Bulk_Scan_Data" title="Anomalous Bulk Scan Data">Anomalous Bulk Scan Data</a>
                </th>
                <td data-sort-value="5">Data Archives
                </td>
                <td data-sort-value="1">
                    <a href="/wiki/Category:Very_common_materials" title="Category:Very common materials">Very Common</a>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Anomalous_FSD_Telemetry" title="Anomalous FSD Telemetry">Anomalous FSD Telemetry</a>
                </th>
                <td data-sort-value="2">Wake Scans
                </td>
                <td data-sort-value="2">
                    <a href="/wiki/Category:Common_materials" title="Category:Common materials">Common</a>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Atypical_Disrupted_Wake_Echoes"
                       title="Atypical Disrupted Wake Echoes">Atypical Disrupted Wake Echoes
                    </a>
                </th>
                <td data-sort-value="2">Wake Scans
                </td>
                <td data-sort-value="1">
                    <a href="/wiki/Category:Very_common_materials" title="Category:Very common materials">Very Common</a>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Atypical_Encryption_Archives"
                       title="Atypical Encryption Archives">Atypical Encryption Archives
                    </a>
                </th>
                <td data-sort-value="4">Encryption Files
                </td>
                <td data-sort-value="4">
                    <a href="/wiki/Category:Rare_materials" title="Category:Rare materials">Rare</a>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Classified_Scan_Databanks"
                       title="Classified Scan Databanks">Classified Scan Databanks
                    </a>
                </th>
                <td data-sort-value="5">Data Archives
                </td>
                <td data-sort-value="3">
                    <a href="/wiki/Category:Standard_materials" title="Category:Standard materials">Standard</a>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Classified_Scan_Fragment" title="Classified Scan Fragment">Classified Scan Fragment</a>
                </th>
                <td data-sort-value="5">Data Archives
                </td>
                <td data-sort-value="5">
                    <a href="/wiki/Category:Very_rare_materials" title="Category:Very rare materials">Very Rare</a>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Cracked_Industrial_Firmware"
                       title="Cracked Industrial Firmware">Cracked Industrial Firmware
                    </a>
                </th>
                <td data-sort-value="6">Encoded Firmware
                </td>
                <td data-sort-value="3">
                    <a href="/wiki/Category:Standard_materials" title="Category:Standard materials">Standard</a>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Datamined_Wake_Exceptions"
                       title="Datamined Wake Exceptions">Datamined Wake Exceptions
                    </a>
                </th>
                <td data-sort-value="2">Wake Scans
                </td>
                <td data-sort-value="5">
                    <a href="/wiki/Category:Very_rare_materials" title="Category:Very rare materials">Very Rare</a>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Decoded_Emission_Data" title="Decoded Emission Data">Decoded Emission Data</a>
                </th>
                <td data-sort-value="1">Emission Data
                </td>
                <td data-sort-value="4">
                    <a href="/wiki/Category:Rare_materials" title="Category:Rare materials">Rare</a>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Distorted_Shield_Cycle_Recordings"
                       title="Distorted Shield Cycle Recordings">Distorted Shield Cycle Recordings
                    </a>
                </th>
                <td data-sort-value="3">Shield Data
                </td>
                <td data-sort-value="1">
                    <a href="/wiki/Category:Very_common_materials" title="Category:Very common materials">Very Common</a>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Divergent_Scan_Data" title="Divergent Scan Data">Divergent Scan Data</a>
                </th>
                <td data-sort-value="5">Data Archives
                </td>
                <td data-sort-value="4">
                    <a href="/wiki/Category:Rare_materials" title="Category:Rare materials">Rare</a>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Eccentric_Hyperspace_Trajectories"
                       title="Eccentric Hyperspace Trajectories">Eccentric Hyperspace Trajectories
                    </a>
                </th>
                <td data-sort-value="2">Wake Scans
                </td>
                <td data-sort-value="4">
                    <a href="/wiki/Category:Rare_materials" title="Category:Rare materials">Rare</a>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Exceptional_Scrambled_Emission_Data"
                       title="Exceptional Scrambled Emission Data">Exceptional Scrambled Emission Data
                    </a>
                </th>
                <td data-sort-value="1">Emission Data
                </td>
                <td data-sort-value="1">
                    <a href="/wiki/Category:Very_common_materials" title="Category:Very common materials">Very Common</a>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Guardian_Module_Blueprint_Fragment"
                       title="Guardian Module Blueprint Fragment">Guardian Module Blueprint Fragment
                    </a>
                </th>
                <td data-sort-value="8">Guardian Data
                </td>
                <td data-sort-value="5">
                    <a href="/wiki/Category:Very_rare_materials" title="Category:Very rare materials">Very Rare</a>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Guardian_Vessel_Blueprint_Fragment"
                       title="Guardian Vessel Blueprint Fragment">Guardian Vessel Blueprint Fragment
                    </a>
                </th>
                <td data-sort-value="8">Guardian Data
                </td>
                <td data-sort-value="5">
                    <a href="/wiki/Category:Very_rare_materials" title="Category:Very rare materials">Very Rare</a>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Guardian_Weapon_Blueprint_Fragment"
                       title="Guardian Weapon Blueprint Fragment">Guardian Weapon Blueprint Fragment
                    </a>
                </th>
                <td data-sort-value="8">Guardian Data
                </td>
                <td data-sort-value="5">
                    <a href="/wiki/Category:Very_rare_materials" title="Category:Very rare materials">Very Rare</a>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Inconsistent_Shield_Soak_Analysis"
                       title="Inconsistent Shield Soak Analysis">Inconsistent Shield Soak Analysis
                    </a>
                </th>
                <td data-sort-value="3">Shield Data
                </td>
                <td data-sort-value="2">
                    <a href="/wiki/Category:Common_materials" title="Category:Common materials">Common</a>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Irregular_Emission_Data" title="Irregular Emission Data">Irregular Emission Data</a>
                </th>
                <td data-sort-value="1">Emission Data
                </td>
                <td data-sort-value="2">
                    <a href="/wiki/Category:Common_materials" title="Category:Common materials">Common</a>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Modified_Consumer_Firmware"
                       title="Modified Consumer Firmware">Modified Consumer Firmware
                    </a>
                </th>
                <td data-sort-value="6">Encoded Firmware
                </td>
                <td data-sort-value="2">
                    <a href="/wiki/Category:Common_materials" title="Category:Common materials">Common</a>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Modified_Embedded_Firmware"
                       title="Modified Embedded Firmware">Modified Embedded Firmware
                    </a>
                </th>
                <td data-sort-value="6">Encoded Firmware
                </td>
                <td data-sort-value="5">
                    <a href="/wiki/Category:Very_rare_materials" title="Category:Very rare materials">Very Rare</a>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Open_Symmetric_Keys" title="Open Symmetric Keys">Open Symmetric Keys</a>
                </th>
                <td data-sort-value="4">Encryption Files
                </td>
                <td data-sort-value="3">
                    <a href="/wiki/Category:Standard_materials" title="Category:Standard materials">Standard</a>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Pattern_Alpha_Obelisk_Data"
                       title="Pattern Alpha Obelisk Data">Pattern Alpha Obelisk Data
                    </a>
                </th>
                <td data-sort-value="8">Guardian Data
                </td>
                <td data-sort-value="3">
                    <a href="/wiki/Category:Standard_materials" title="Category:Standard materials">Standard</a>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Pattern_Beta_Obelisk_Data"
                       title="Pattern Beta Obelisk Data">Pattern Beta Obelisk Data
                    </a>
                </th>
                <td data-sort-value="8">Guardian Data
                </td>
                <td data-sort-value="2">
                    <a href="/wiki/Category:Common_materials" title="Category:Common materials">Common</a>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Pattern_Delta_Obelisk_Data"
                       title="Pattern Delta Obelisk Data">Pattern Delta Obelisk Data
                    </a>
                </th>
                <td data-sort-value="8">Guardian Data
                </td>
                <td data-sort-value="4">
                    <a href="/wiki/Category:Rare_materials" title="Category:Rare materials">Rare</a>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Pattern_Epsilon_Obelisk_Data"
                       title="Pattern Epsilon Obelisk Data">Pattern Epsilon Obelisk Data
                    </a>
                </th>
                <td data-sort-value="8">Guardian Data
                </td>
                <td data-sort-value="5">
                    <a href="/wiki/Category:Very_rare_materials" title="Category:Very rare materials">Very Rare</a>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Pattern_Gamma_Obelisk_Data"
                       title="Pattern Gamma Obelisk Data">Pattern Gamma Obelisk Data
                    </a>
                </th>
                <td data-sort-value="8">Guardian Data
                </td>
                <td data-sort-value="1">
                    <a href="/wiki/Category:Very_common_materials" title="Category:Very common materials">Very Common</a>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Peculiar_Shield_Frequency_Data"
                       title="Peculiar Shield Frequency Data">Peculiar Shield Frequency Data
                    </a>
                </th>
                <td data-sort-value="3">Shield Data
                </td>
                <td data-sort-value="5">
                    <a href="/wiki/Category:Very_rare_materials" title="Category:Very rare materials">Very Rare</a>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Security_Firmware_Patch" title="Security Firmware Patch">Security Firmware Patch</a>
                </th>
                <td data-sort-value="6">Encoded Firmware
                </td>
                <td data-sort-value="4">
                    <a href="/wiki/Category:Rare_materials" title="Category:Rare materials">Rare</a>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Ship_Flight_Data" title="Ship Flight Data">Ship Flight Data</a>
                </th>
                <td data-sort-value="7">Thargoid Data
                </td>
                <td data-sort-value="3">
                    <a href="/wiki/Category:Standard_materials" title="Category:Standard materials">Standard</a>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Ship_Systems_Data" title="Ship Systems Data">Ship Systems Data</a>
                </th>
                <td data-sort-value="7">Thargoid Data
                </td>
                <td data-sort-value="3">
                    <a href="/wiki/Category:Standard_materials" title="Category:Standard materials">Standard</a>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Specialised_Legacy_Firmware"
                       title="Specialised Legacy Firmware">Specialised Legacy Firmware
                    </a>
                </th>
                <td data-sort-value="6">Encoded Firmware
                </td>
                <td data-sort-value="1">
                    <a href="/wiki/Category:Very_common_materials" title="Category:Very common materials">Very Common</a>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Strange_Wake_Solutions" title="Strange Wake Solutions">Strange Wake Solutions</a>
                </th>
                <td data-sort-value="2">Wake Scans
                </td>
                <td data-sort-value="3">
                    <a href="/wiki/Category:Standard_materials" title="Category:Standard materials">Standard</a>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Tagged_Encryption_Codes" title="Tagged Encryption Codes">Tagged Encryption Codes</a>
                </th>
                <td data-sort-value="4">Encryption Files
                </td>
                <td data-sort-value="2">
                    <a href="/wiki/Category:Common_materials" title="Category:Common materials">Common</a>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Thargoid_Material_Composition_Data"
                       title="Thargoid Material Composition Data">Thargoid Material Composition Data
                    </a>
                </th>
                <td data-sort-value="7">Thargoid Data
                </td>
                <td data-sort-value="3">
                    <a href="/wiki/Category:Standard_materials" title="Category:Standard materials">Standard</a>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Thargoid_Residue_Data" title="Thargoid Residue Data">Thargoid Residue Data</a>
                </th>
                <td data-sort-value="7">Thargoid Data
                </td>
                <td data-sort-value="4">
                    <a href="/wiki/Category:Rare_materials" title="Category:Rare materials">Rare</a>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Thargoid_Ship_Signature" title="Thargoid Ship Signature">Thargoid Ship Signature</a>
                </th>
                <td data-sort-value="7">Thargoid Data
                </td>
                <td data-sort-value="3">
                    <a href="/wiki/Category:Standard_materials" title="Category:Standard materials">Standard</a>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Thargoid_Structural_Data" title="Thargoid Structural Data">Thargoid Structural Data</a>
                </th>
                <td data-sort-value="7">Thargoid Data
                </td>
                <td data-sort-value="2">
                    <a href="/wiki/Category:Common_materials" title="Category:Common materials">Common</a>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Thargoid_Wake_Data" title="Thargoid Wake Data">Thargoid Wake Data</a>
                </th>
                <td data-sort-value="7">Thargoid Data
                </td>
                <td data-sort-value="4">
                    <a href="/wiki/Category:Rare_materials" title="Category:Rare materials">Rare</a>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Unexpected_Emission_Data" title="Unexpected Emission Data">Unexpected Emission Data</a>
                </th>
                <td data-sort-value="1">Emission Data
                </td>
                <td data-sort-value="3">
                    <a href="/wiki/Category:Standard_materials" title="Category:Standard materials">Standard</a>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Unidentified_Scan_Archives"
                       title="Unidentified Scan Archives">Unidentified Scan Archives
                    </a>
                </th>
                <td data-sort-value="5">Data Archives
                </td>
                <td data-sort-value="2">
                    <a href="/wiki/Category:Common_materials" title="Category:Common materials">Common</a>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Untypical_Shield_Scans" title="Untypical Shield Scans">Untypical Shield Scans</a>
                </th>
                <td data-sort-value="3">Shield Data
                </td>
                <td data-sort-value="3">
                    <a href="/wiki/Category:Standard_materials" title="Category:Standard materials">Standard</a>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Unusual_Encrypted_Files" title="Unusual Encrypted Files">Unusual Encrypted Files</a>
                </th>
                <td data-sort-value="4">Encryption Files
                </td>
                <td data-sort-value="1">
                    <a href="/wiki/Category:Very_common_materials" title="Category:Very common materials">Very Common</a>
                </td>
            </tr>
        </tbody>
        <tfoot></tfoot>
    </table>
</div>
<div id="manf" class="d-none">
    <h2>Manufactured materials</h2>
    <table class="article-table article-table-selected sortable jquery-tablesorter">
        <thead>
            <tr>
                <th scope="col" class="headerSort" tabindex="0" role="columnheader button" title="Sort ascending">Name
                </th>
                <th scope="col" class="headerSort" tabindex="0" role="columnheader button" title="Sort ascending">Category
                </th>
                <th scope="col" class="headerSort" tabindex="0" role="columnheader button" title="Sort ascending">Grade
                </th>
                <th class="headerSort" tabindex="0" role="columnheader button" title="Sort ascending">Obtained via:
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>
                    <a href="/wiki/Basic_Conductors" title="Basic Conductors">Basic Conductors</a>
                </th>
                <td data-sort-value="4">Conductive
                </td>
                <td data-sort-value="1">
                    <a href="/wiki/Category:Very_common_materials" title="Category:Very common materials">Very Common</a>
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Bio-Mechanical_Conduits" title="Bio-Mechanical Conduits">Bio-Mechanical Conduits</a>
                </th>
                <td data-sort-value="11">Thargoid Components
                </td>
                <td data-sort-value="3">
                    <a href="/wiki/Category:Standard_materials" title="Category:Standard materials">Standard</a>
                </td>
                <td>Thargoid encounters
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Biotech_Conductors" title="Biotech Conductors">Biotech Conductors</a>
                </th>
                <td data-sort-value="4">Conductive
                </td>
                <td data-sort-value="5">
                    <a href="/wiki/Category:Very_rare_materials" title="Category:Very rare materials">Very Rare</a>
                </td>
                <td>Missions
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Chemical_Distillery" title="Chemical Distillery">Chemical Distillery</a>
                </th>
                <td data-sort-value="1">Chemical
                </td>
                <td data-sort-value="3">
                    <a href="/wiki/Category:Standard_materials" title="Category:Standard materials">Standard</a>
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Chemical_Manipulators" title="Chemical Manipulators">Chemical Manipulators</a>
                </th>
                <td data-sort-value="1">Chemical
                </td>
                <td data-sort-value="4">
                    <a href="/wiki/Category:Rare_materials" title="Category:Rare materials">Rare</a>
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Chemical_Processors" title="Chemical Processors">Chemical Processors</a>
                </th>
                <td data-sort-value="1">Chemical
                </td>
                <td data-sort-value="2">
                    <a href="/wiki/Category:Common_materials" title="Category:Common materials">Common</a>
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Chemical_Storage_Units" title="Chemical Storage Units">Chemical Storage Units</a>
                </th>
                <td data-sort-value="1">Chemical
                </td>
                <td data-sort-value="1">
                    <a href="/wiki/Category:Very_common_materials" title="Category:Very common materials">Very Common</a>
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Compact_Composites" title="Compact Composites">Compact Composites</a>
                </th>
                <td data-sort-value="8">Composite
                </td>
                <td data-sort-value="1">
                    <a href="/wiki/Category:Very_common_materials" title="Category:Very common materials">Very Common</a>
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Compound_Shielding" title="Compound Shielding">Compound Shielding</a>
                </th>
                <td data-sort-value="7">Shielding
                </td>
                <td data-sort-value="4">
                    <a href="/wiki/Category:Rare_materials" title="Category:Rare materials">Rare</a>
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Conductive_Ceramics" title="Conductive Ceramics">Conductive Ceramics</a>
                </th>
                <td data-sort-value="4">Conductive
                </td>
                <td data-sort-value="3">
                    <a href="/wiki/Category:Standard_materials" title="Category:Standard materials">Standard</a>
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Conductive_Components" title="Conductive Components">Conductive Components</a>
                </th>
                <td data-sort-value="4">Conductive
                </td>
                <td data-sort-value="2">
                    <a href="/wiki/Category:Common_materials" title="Category:Common materials">Common</a>
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Conductive_Polymers" title="Conductive Polymers">Conductive Polymers</a>
                </th>
                <td data-sort-value="4">Conductive
                </td>
                <td data-sort-value="4">
                    <a href="/wiki/Category:Rare_materials" title="Category:Rare materials">Rare</a>
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Configurable_Components" title="Configurable Components">Configurable Components</a>
                </th>
                <td data-sort-value="5">Mechanical Components
                </td>
                <td data-sort-value="4">
                    <a href="/wiki/Category:Rare_materials" title="Category:Rare materials">Rare</a>
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Core_Dynamics_Composites" title="Core Dynamics Composites">Core Dynamics Composites</a>
                </th>
                <td data-sort-value="8">Composite
                </td>
                <td data-sort-value="5">
                    <a href="/wiki/Category:Very_rare_materials" title="Category:Very rare materials">Very Rare</a>
                </td>
                <td>Federation systems (HGE)
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Crystal_Shards" title="Crystal Shards">Crystal Shards</a>
                </th>
                <td data-sort-value="9">Crystals
                </td>
                <td data-sort-value="1">
                    <a href="/wiki/Category:Very_common_materials" title="Category:Very common materials">Very Common</a>
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Electrochemical_Arrays" title="Electrochemical Arrays">Electrochemical Arrays</a>
                </th>
                <td data-sort-value="6">Capacitors
                </td>
                <td data-sort-value="3">
                    <a href="/wiki/Category:Standard_materials" title="Category:Standard materials">Standard</a>
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Exquisite_Focus_Crystals" title="Exquisite Focus Crystals">Exquisite Focus Crystals</a>
                </th>
                <td data-sort-value="9">Crystals
                </td>
                <td data-sort-value="5">
                    <a href="/wiki/Category:Very_rare_materials" title="Category:Very rare materials">Very Rare</a>
                </td>
                <td>Missions
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Filament_Composites" title="Filament Composites">Filament Composites</a>
                </th>
                <td data-sort-value="8">Composite
                </td>
                <td data-sort-value="2">
                    <a href="/wiki/Category:Common_materials" title="Category:Common materials">Common</a>
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Flawed_Focus_Crystals" title="Flawed Focus Crystals">Flawed Focus Crystals</a>
                </th>
                <td data-sort-value="9">Crystals
                </td>
                <td data-sort-value="2">
                    <a href="/wiki/Category:Common_materials" title="Category:Common materials">Common</a>
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Focus_Crystals" title="Focus Crystals">Focus Crystals</a>
                </th>
                <td data-sort-value="9">Crystals
                </td>
                <td data-sort-value="3">
                    <a href="/wiki/Category:Standard_materials" title="Category:Standard materials">Standard</a>
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Galvanising_Alloys" title="Galvanising Alloys">Galvanising Alloys</a>
                </th>
                <td data-sort-value="10">Alloys
                </td>
                <td data-sort-value="2">
                    <a href="/wiki/Category:Common_materials" title="Category:Common materials">Common</a>
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Grid_Resistors" title="Grid Resistors">Grid Resistors</a>
                </th>
                <td data-sort-value="6">Capacitors
                </td>
                <td data-sort-value="1">
                    <a href="/wiki/Category:Very_common_materials" title="Category:Very common materials">Very Common</a>
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Guardian_Power_Cell" title="Guardian Power Cell">Guardian Power Cell</a>
                </th>
                <td data-sort-value="12">Guardian Components
                </td>
                <td data-sort-value="1">
                    <a href="/wiki/Category:Very_common_materials" title="Category:Very common materials">Very Common</a>
                </td>
                <td>Guardian sites
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Guardian_Power_Conduit" title="Guardian Power Conduit">Guardian Power Conduit</a>
                </th>
                <td data-sort-value="12">Guardian Components
                </td>
                <td data-sort-value="2">
                    <a href="/wiki/Category:Common_materials" title="Category:Common materials">Common</a>
                </td>
                <td>Guardian sites
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Guardian_Sentinel_Weapon_Parts"
                       title="Guardian Sentinel Weapon Parts">Guardian Sentinel Weapon Parts
                    </a>
                </th>
                <td data-sort-value="12">Guardian Components
                </td>
                <td data-sort-value="3">
                    <a href="/wiki/Category:Standard_materials" title="Category:Standard materials">Standard</a>
                </td>
                <td>Guardian sites
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Guardian_Technology_Component"
                       title="Guardian Technology Component">Guardian Technology Component
                    </a>
                </th>
                <td data-sort-value="12">Guardian Components
                </td>
                <td data-sort-value="2">
                    <a href="/wiki/Category:Common_materials" title="Category:Common materials">Common</a>
                </td>
                <td>Guardian sites
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Guardian_Wreckage_Components"
                       title="Guardian Wreckage Components">Guardian Wreckage Components
                    </a>
                </th>
                <td data-sort-value="12">Guardian Components
                </td>
                <td data-sort-value="1">
                    <a href="/wiki/Category:Very_common_materials" title="Category:Very common materials">Very Common</a>
                </td>
                <td>Guardian sites
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Heat_Conduction_Wiring" title="Heat Conduction Wiring">Heat Conduction Wiring</a>
                </th>
                <td data-sort-value="3">Heat
                </td>
                <td data-sort-value="1">
                    <a href="/wiki/Category:Very_common_materials" title="Category:Very common materials">Very Common</a>
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Heat_Dispersion_Plate" title="Heat Dispersion Plate">Heat Dispersion Plate</a>
                </th>
                <td data-sort-value="3">Heat
                </td>
                <td data-sort-value="2">
                    <a href="/wiki/Category:Common_materials" title="Category:Common materials">Common</a>
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Heat_Exchangers" title="Heat Exchangers">Heat Exchangers</a>
                </th>
                <td data-sort-value="3">Heat
                </td>
                <td data-sort-value="3">
                    <a href="/wiki/Category:Standard_materials" title="Category:Standard materials">Standard</a>
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Heat_Resistant_Ceramics" title="Heat Resistant Ceramics">Heat Resistant Ceramics</a>
                </th>
                <td data-sort-value="2">Thermic
                </td>
                <td data-sort-value="2">
                    <a href="/wiki/Category:Common_materials" title="Category:Common materials">Common</a>
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Heat_Vanes" title="Heat Vanes">Heat Vanes</a>
                </th>
                <td data-sort-value="3">Heat
                </td>
                <td data-sort-value="4">
                    <a href="/wiki/Category:Rare_materials" title="Category:Rare materials">Rare</a>
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/High_Density_Composites" title="High Density Composites">High Density Composites</a>
                </th>
                <td data-sort-value="8">Composite
                </td>
                <td data-sort-value="3">
                    <a href="/wiki/Category:Standard_materials" title="Category:Standard materials">Standard</a>
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Hybrid_Capacitors" title="Hybrid Capacitors">Hybrid Capacitors</a>
                </th>
                <td data-sort-value="6">Capacitors
                </td>
                <td data-sort-value="2">
                    <a href="/wiki/Category:Common_materials" title="Category:Common materials">Common</a>
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Imperial_Shielding" title="Imperial Shielding">Imperial Shielding</a>
                </th>
                <td data-sort-value="7">Shielding
                </td>
                <td data-sort-value="5">
                    <a href="/wiki/Category:Very_rare_materials" title="Category:Very rare materials">Very Rare</a>
                </td>
                <td>Empire systems (HGE)
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Improvised_Components" title="Improvised Components">Improvised Components</a>
                </th>
                <td data-sort-value="5">Mechanical Components
                </td>
                <td data-sort-value="5">
                    <a href="/wiki/Category:Very_rare_materials" title="Category:Very rare materials">Very Rare</a>
                </td>
                <td>Civil unrest systems (HGE)
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Mechanical_Components" title="Mechanical Components">Mechanical Components</a>
                </th>
                <td data-sort-value="5">Mechanical Components
                </td>
                <td data-sort-value="3">
                    <a href="/wiki/Category:Standard_materials" title="Category:Standard materials">Standard</a>
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Mechanical_Equipment" title="Mechanical Equipment">Mechanical Equipment</a>
                </th>
                <td data-sort-value="5">Mechanical Components
                </td>
                <td data-sort-value="2">
                    <a href="/wiki/Category:Common_materials" title="Category:Common materials">Common</a>
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Mechanical_Scrap" title="Mechanical Scrap">Mechanical Scrap</a>
                </th>
                <td data-sort-value="5">Mechanical Components
                </td>
                <td data-sort-value="1">
                    <a href="/wiki/Category:Very_common_materials" title="Category:Very common materials">Very Common</a>
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Military_Grade_Alloys" title="Military Grade Alloys">Military Grade Alloys</a>
                </th>
                <td data-sort-value="2">Thermic
                </td>
                <td data-sort-value="5">
                    <a href="/wiki/Category:Very_rare_materials" title="Category:Very rare materials">Very Rare</a>
                </td>
                <td>War/Civil war/Civil unrest systems (HGE)
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Military_Supercapacitors" title="Military Supercapacitors">Military Supercapacitors</a>
                </th>
                <td data-sort-value="6">Capacitors
                </td>
                <td data-sort-value="5">
                    <a href="/wiki/Category:Very_rare_materials" title="Category:Very rare materials">Very Rare</a>
                </td>
                <td>War/civil war systems (HGE)
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Pharmaceutical_Isolators" title="Pharmaceutical Isolators">Pharmaceutical Isolators</a>
                </th>
                <td data-sort-value="1">Chemical
                </td>
                <td data-sort-value="5">
                    <a href="/wiki/Category:Very_rare_materials" title="Category:Very rare materials">Very Rare</a>
                </td>
                <td>Outbreak systems (HGE)
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Phase_Alloys" title="Phase Alloys">Phase Alloys</a>
                </th>
                <td data-sort-value="10">Alloys
                </td>
                <td data-sort-value="3">
                    <a href="/wiki/Category:Standard_materials" title="Category:Standard materials">Standard</a>
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Polymer_Capacitors" title="Polymer Capacitors">Polymer Capacitors</a>
                </th>
                <td data-sort-value="6">Capacitors
                </td>
                <td data-sort-value="4">
                    <a href="/wiki/Category:Rare_materials" title="Category:Rare materials">Rare</a>
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Precipitated_Alloys" title="Precipitated Alloys">Precipitated Alloys</a>
                </th>
                <td data-sort-value="2">Thermic
                </td>
                <td data-sort-value="3">
                    <a href="/wiki/Category:Standard_materials" title="Category:Standard materials">Standard</a>
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Proprietary_Composites" title="Proprietary Composites">Proprietary Composites</a>
                </th>
                <td data-sort-value="8">Composite
                </td>
                <td data-sort-value="4">
                    <a href="/wiki/Category:Rare_materials" title="Category:Rare materials">Rare</a>
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Propulsion_Elements" title="Propulsion Elements">Propulsion Elements</a>
                </th>
                <td data-sort-value="11">Thargoid Components
                </td>
                <td data-sort-value="3">
                    <a href="/wiki/Category:Standard_materials" title="Category:Standard materials">Standard</a>
                </td>
                <td>Thargoid encounters
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Proto_Heat_Radiators" title="Proto Heat Radiators">Proto Heat Radiators</a>
                </th>
                <td data-sort-value="3">Heat
                </td>
                <td data-sort-value="5">
                    <a href="/wiki/Category:Very_rare_materials" title="Category:Very rare materials">Very Rare</a>
                </td>
                <td>Independent boom systems (HGE)
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Proto_Light_Alloys" title="Proto Light Alloys">Proto Light Alloys</a>
                </th>
                <td data-sort-value="10">Alloys
                </td>
                <td data-sort-value="4">
                    <a href="/wiki/Category:Rare_materials" title="Category:Rare materials">Rare</a>
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Proto_Radiolic_Alloys" title="Proto Radiolic Alloys">Proto Radiolic Alloys</a>
                </th>
                <td data-sort-value="10">Alloys
                </td>
                <td data-sort-value="5">
                    <a href="/wiki/Category:Very_rare_materials" title="Category:Very rare materials">Very Rare</a>
                </td>
                <td>Independent boom systems (HGE)
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Refined_Focus_Crystals" title="Refined Focus Crystals">Refined Focus Crystals</a>
                </th>
                <td data-sort-value="9">Crystals
                </td>
                <td data-sort-value="4">
                    <a href="/wiki/Category:Rare_materials" title="Category:Rare materials">Rare</a>
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Salvaged_Alloys" title="Salvaged Alloys">Salvaged Alloys</a>
                </th>
                <td data-sort-value="10">Alloys
                </td>
                <td data-sort-value="1">
                    <a href="/wiki/Category:Very_common_materials" title="Category:Very common materials">Very Common</a>
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Sensor_Fragment" title="Sensor Fragment">Sensor Fragment</a>
                </th>
                <td data-sort-value="11">Thargoid Components
                </td>
                <td data-sort-value="5">
                    <a href="/wiki/Category:Very_rare_materials" title="Category:Very rare materials">Very Rare</a>
                </td>
                <td>Thargoid encounters
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Shield_Emitters" title="Shield Emitters">Shield Emitters</a>
                </th>
                <td data-sort-value="7">Shielding
                </td>
                <td data-sort-value="2">
                    <a href="/wiki/Category:Common_materials" title="Category:Common materials">Common</a>
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Shielding_Sensors" title="Shielding Sensors">Shielding Sensors</a>
                </th>
                <td data-sort-value="7">Shielding
                </td>
                <td data-sort-value="3">
                    <a href="/wiki/Category:Standard_materials" title="Category:Standard materials">Standard</a>
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Tempered_Alloys" title="Tempered Alloys">Tempered Alloys</a>
                </th>
                <td data-sort-value="2">Thermic
                </td>
                <td data-sort-value="1">
                    <a href="/wiki/Category:Very_common_materials" title="Category:Very common materials">Very Common</a>
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Thargoid_Carapace" title="Thargoid Carapace">Thargoid Carapace</a>
                </th>
                <td data-sort-value="11">Thargoid Components
                </td>
                <td data-sort-value="2">
                    <a href="/wiki/Category:Common_materials" title="Category:Common materials">Common</a>
                </td>
                <td>Thargoid encounters
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Thargoid_Energy_Cell" title="Thargoid Energy Cell">Thargoid Energy Cell</a>
                </th>
                <td data-sort-value="11">Thargoid Components
                </td>
                <td data-sort-value="3">
                    <a href="/wiki/Category:Standard_materials" title="Category:Standard materials">Standard</a>
                </td>
                <td>Thargoid encounters
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Thargoid_Organic_Circuitry"
                       title="Thargoid Organic Circuitry">Thargoid Organic Circuitry
                    </a>
                </th>
                <td data-sort-value="11">Thargoid Components
                </td>
                <td data-sort-value="5">
                    <a href="/wiki/Category:Very_rare_materials" title="Category:Very rare materials">Very Rare</a>
                </td>
                <td>Thargoid encounters
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Thargoid_Technology_Components"
                       class="mw-redirect"
                       title="Thargoid Technology Components">Thargoid Technology Components
                    </a>
                </th>
                <td data-sort-value="11">Thargoid Components
                </td>
                <td data-sort-value="4">
                    <a href="/wiki/Category:Rare_materials" title="Category:Rare materials">Rare</a>
                </td>
                <td>Thargoid encounters
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Thermic_Alloys" title="Thermic Alloys">Thermic Alloys</a>
                </th>
                <td data-sort-value="2">Thermic
                </td>
                <td data-sort-value="4">
                    <a href="/wiki/Category:Rare_materials" title="Category:Rare materials">Rare</a>
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Weapon_Parts" title="Weapon Parts">Weapon Parts</a>
                </th>
                <td data-sort-value="11">Thargoid Components
                </td>
                <td data-sort-value="3">
                    <a href="/wiki/Category:Standard_materials" title="Category:Standard materials">Standard</a>
                </td>
                <td>Thargoid encounters
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Worn_Shield_Emitters" title="Worn Shield Emitters">Worn Shield Emitters</a>
                </th>
                <td data-sort-value="7">Shielding
                </td>
                <td data-sort-value="1">
                    <a href="/wiki/Category:Very_common_materials" title="Category:Very common materials">Very Common</a>
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Wreckage_Components_(Material)"
                       title="Wreckage Components (Material)">Wreckage Components
                    </a>
                </th>
                <td data-sort-value="11">Thargoid Components
                </td>
                <td data-sort-value="3">
                    <a href="/wiki/Category:Standard_materials" title="Category:Standard materials">Standard</a>
                </td>
                <td>Thargoid encounters
                </td>
            </tr>
        </tbody>
        <tfoot></tfoot>
    </table>
</div>
<div id="raw" class="d-none">
    <h2>Raw materials</h2>
    <table class="article-table article-table-selected sortable jquery-tablesorter">
        <thead>
            <tr>
                <th scope="col" class="headerSort" tabindex="0" role="columnheader button" title="Sort ascending">Name
                </th>
                <th scope="col" class="headerSort" tabindex="0" role="columnheader button" title="Sort ascending">Category
                </th>
                <th scope="col" class="headerSort" tabindex="0" role="columnheader button" title="Sort ascending">Grade
                </th>
                <th class="headerSort" tabindex="0" role="columnheader button" title="Sort ascending">Locations
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>
                    <a href="/wiki/Antimony" title="Antimony">Antimony</a>
                </th>
                <td>7
                </td>
                <td data-sort-value="4">
                    <a href="/wiki/Category:Very_rare_materials" title="Category:Very rare materials">Rare</a>
                </td>
                <td>Planet surfaces
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Arsenic" title="Arsenic">Arsenic</a>
                </th>
                <td>6
                </td>
                <td data-sort-value="2">
                    <a href="/wiki/Category:Common_materials" title="Category:Common materials">Common</a>
                </td>
                <td>Planet surfaces, asteroids
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Boron" title="Boron">Boron</a>
                </th>
                <td>7
                </td>
                <td data-sort-value="3">
                    <a href="/wiki/Category:Standard_materials" title="Category:Standard materials">Standard</a>
                </td>
                <td>Asteroids
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Cadmium" title="Cadmium">Cadmium</a>
                </th>
                <td>3
                </td>
                <td data-sort-value="3">
                    <a href="/wiki/Category:Standard_materials" title="Category:Standard materials">Standard</a>
                </td>
                <td>Planet surfaces
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Carbon" title="Carbon">Carbon</a>
                </th>
                <td>1
                </td>
                <td data-sort-value="1">
                    <a href="/wiki/Category:Very_common_materials" title="Category:Very common materials">Very Common</a>
                </td>
                <td>Planet surfaces, asteroids
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Chromium" title="Chromium">Chromium</a>
                </th>
                <td>2
                </td>
                <td data-sort-value="2">
                    <a href="/wiki/Category:Common_materials" title="Category:Common materials">Common</a>
                </td>
                <td>Planet surfaces, asteroids
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Germanium" title="Germanium">Germanium</a>
                </th>
                <td>5
                </td>
                <td data-sort-value="2">
                    <a href="/wiki/Category:Common_materials" title="Category:Common materials">Common</a>
                </td>
                <td>Planet surfaces, asteroids
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Iron" title="Iron">Iron</a>
                </th>
                <td>4
                </td>
                <td data-sort-value="1">
                    <a href="/wiki/Category:Very_common_materials" title="Category:Very common materials">Very Common</a>
                </td>
                <td>Planet surfaces, asteroids
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Lead" title="Lead">Lead</a>
                </th>
                <td>7
                </td>
                <td data-sort-value="1">
                    <a href="/wiki/Category:Very_common_materials" title="Category:Very common materials">Very Common</a>
                </td>
                <td>Asteroids
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Manganese" title="Manganese">Manganese</a>
                </th>
                <td>3
                </td>
                <td data-sort-value="2">
                    <a href="/wiki/Category:Common_materials" title="Category:Common materials">Common</a>
                </td>
                <td>Planet surfaces, asteroids
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Mercury" title="Mercury">Mercury</a>
                </th>
                <td>6
                </td>
                <td data-sort-value="3">
                    <a href="/wiki/Category:Standard_materials" title="Category:Standard materials">Standard</a>
                </td>
                <td>Planet surfaces
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Molybdenum" title="Molybdenum">Molybdenum</a>
                </th>
                <td>2
                </td>
                <td data-sort-value="3">
                    <a href="/wiki/Category:Standard_materials" title="Category:Standard materials">Standard</a>
                </td>
                <td>Planet surfaces
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Nickel" title="Nickel">Nickel</a>
                </th>
                <td>5
                </td>
                <td data-sort-value="1">
                    <a href="/wiki/Category:Very_common_materials" title="Category:Very common materials">Very Common</a>
                </td>
                <td>Planet surfaces, asteroids
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Niobium" title="Niobium">Niobium</a>
                </th>
                <td>1
                </td>
                <td data-sort-value="3">
                    <a href="/wiki/Category:Standard_materials" title="Category:Standard materials">Standard</a>
                </td>
                <td>Planet surfaces, asteroids
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Phosphorus" title="Phosphorus">Phosphorus</a>
                </th>
                <td>2
                </td>
                <td data-sort-value="1">
                    <a href="/wiki/Category:Very_common_materials" title="Category:Very common materials">Very Common</a>
                </td>
                <td>Planet surfaces, asteroids
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Polonium" title="Polonium">Polonium</a>
                </th>
                <td>6
                </td>
                <td data-sort-value="4">
                    <a href="/wiki/Category:Very_rare_materials" title="Category:Very rare materials">Rare</a>
                </td>
                <td>Planet surfaces
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Rhenium" title="Rhenium">Rhenium</a>
                </th>
                <td>6
                </td>
                <td data-sort-value="1">
                    <a href="/wiki/Category:Very_common_materials" title="Category:Very common materials">Very Common</a>
                </td>
                <td>Asteroids
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Ruthenium" title="Ruthenium">Ruthenium</a>
                </th>
                <td>3
                </td>
                <td data-sort-value="4">
                    <a href="/wiki/Category:Rare_materials" title="Category:Rare materials">Rare</a>
                </td>
                <td>Planet surfaces
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Selenium" title="Selenium">Selenium</a>
                </th>
                <td>4
                </td>
                <td data-sort-value="4">
                    <a href="/wiki/Category:Rare_materials" title="Category:Rare materials">Rare</a>
                </td>
                <td>Planet surfaces, asteroids
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Sulphur" title="Sulphur">Sulphur</a>
                </th>
                <td>3
                </td>
                <td data-sort-value="1">
                    <a href="/wiki/Category:Very_common_materials" title="Category:Very common materials">Very Common</a>
                </td>
                <td>Planet surfaces, asteroids
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Technetium" title="Technetium">Technetium</a>
                </th>
                <td>2
                </td>
                <td data-sort-value="4">
                    <a href="/wiki/Category:Rare_materials" title="Category:Rare materials">Rare</a>
                </td>
                <td>Planet surfaces
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Tellurium" title="Tellurium">Tellurium</a>
                </th>
                <td>5
                </td>
                <td data-sort-value="4">
                    <a href="/wiki/Category:Rare_materials" title="Category:Rare materials">Rare</a>
                </td>
                <td>Planet surfaces
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Tin" title="Tin">Tin</a>
                </th>
                <td>4
                </td>
                <td data-sort-value="3">
                    <a href="/wiki/Category:Standard_materials" title="Category:Standard materials">Standard</a>
                </td>
                <td>Planet surfaces
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Tungsten" title="Tungsten">Tungsten</a>
                </th>
                <td>5
                </td>
                <td data-sort-value="3">
                    <a href="/wiki/Category:Standard_materials" title="Category:Standard materials">Standard</a>
                </td>
                <td>Planet surfaces, asteroids
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Vanadium" title="Vanadium">Vanadium</a>
                </th>
                <td>1
                </td>
                <td data-sort-value="2">
                    <a href="/wiki/Category:Common_materials" title="Category:Common materials">Common</a>
                </td>
                <td>Planet surfaces, asteroids
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Yttrium" title="Yttrium">Yttrium</a>
                </th>
                <td>1
                </td>
                <td data-sort-value="4">
                    <a href="/wiki/Category:Rare_materials" title="Category:Rare materials">Rare</a>
                </td>
                <td>Planet surfaces
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Zinc" title="Zinc">Zinc</a>
                </th>
                <td>4
                </td>
                <td data-sort-value="2">
                    <a href="/wiki/Category:Common_materials" title="Category:Common materials">Common</a>
                </td>
                <td>Planet surfaces, asteroids
                </td>
            </tr>
            <tr>
                <th>
                    <a href="/wiki/Zirconium" title="Zirconium">Zirconium</a>
                </th>
                <td>7
                </td>
                <td data-sort-value="2">
                    <a href="/wiki/Category:Rare_materials" title="Category:Rare materials">Common</a>
                </td>
                <td>Planet surfaces, asteroids
                </td>
            </tr>
        </tbody>
        <tfoot></tfoot>
    </table>
</div>


