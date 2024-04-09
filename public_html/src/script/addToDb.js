export const getMaterialsFromTable = async (fetchData) => {
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

    console.log(table);

    $('#addMaterials').on('click', async function() {
        const url = '/addtodb/materials';
        const result = await fetchData(url, 'POST', JSON.stringify(table));
        console.log(result);
    });
};