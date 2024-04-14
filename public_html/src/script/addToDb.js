export const getDataFromDom = async (fetchData) => {
    const getMaterials = () => {
        const table = [];

        $('#encoded tbody tr').each(function() {
            table.push({
                name: $(this).find('th').text().trim(),
                category: $(this).find('td').eq(0).text().trim(),
                grade: $(this).find('td').eq(1).text().trim(),
                type: 'encoded',
                location: ''
            });
        });

        $('#manf tbody tr').each(function() {
            table.push({
                name: $(this).find('th').text().trim(),
                category: $(this).find('td').eq(0).text().trim(),
                grade: $(this).find('td').eq(1).text().trim(),
                type: 'manufactured',
                location: $(this).find('td').eq(2).text().trim(),
            });
        });

        $('#raw tbody tr').each(function() {
            table.push({
                name: $(this).find('th').text().trim(),
                category: $(this).find('td').eq(0).text().trim(),
                grade: $(this).find('td').eq(1).text().trim(),
                type: 'raw',
                location: $(this).find('td').eq(2).text().trim(),
            });
        });

        // console.log(table);
        $('#addMaterials').on('click', async function() {
            const url = '/addtodb/materials';
            const result = await fetchData(url, 'POST', JSON.stringify(table));
            console.log(result);
        });
    };

    // const getEngineers = () => {
    //     const table = [];
    //
    //     $('#engineers-table > tbody tr').each(function(i) {
    //         table.push({
    //             name: $(this).find('td:nth-child(1) > a').text().trim(),
    //             station: $(this).find('td:nth-child(2)').eq(0).text().trim(),
    //             system: $(this).find('td:nth-child(4) > a').text().trim()
    //         });
    //         $('.eng-details table:nth-child(1) tbody tr td').each(function(index) {
    //             switch (index) {
    //                 case 0 :
    //                     table[i].discovery = $(this).text().trim();
    //                     break;
    //                 case 1 :
    //                     table[i].meetingReq = $(this).text().trim();
    //                     break;
    //                 case 2 :
    //                     table[i].unlockReq = $(this).text().trim();
    //                     break;
    //                 case 3 :
    //                     table[i].repGain = $(this).text().trim();
    //                     break;
    //             }
    //         });
    //     });
    //
    //     console.log(table);
    //     $('#addMaterials').on('click', async function() {
    //         const url = '/addtodb/engineers';
    //         const result = await fetchData(url, 'POST', JSON.stringify(table));
    //         console.log(result);
    //     });
    // };

    if ($('#encoded tbody tr').length) getMaterials();
    // if ($('#engineers-table').length) getEngineers();
};