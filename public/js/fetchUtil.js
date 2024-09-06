/**
 * Realiza una solicitud HTTP usando fetch.
 * @param {string} url - La URL a la que se hará la solicitud.
 * @param {object} options - Opciones para la solicitud (método, cabeceras, cuerpo, etc.).
 * @returns {Promise<object>} - La respuesta en formato JSON.
 */
async function fetchRequest(url, options = {}) {
    const defaultOptions = {
        method: 'GET', // Por defecto, el método es GET
        headers: {
            'Content-Type': 'application/json',
        },
    };

    // Combina las opciones por defecto con las opciones pasadas
    const finalOptions = { ...defaultOptions, ...options };

    try {
        const response = await fetch(url, finalOptions);

        if (!response.ok) {
            throw new Error(`Error ${response.status}: ${response.statusText}`);
        }
        return await response.json();
    } catch (error) {
        console.error('Error en la solicitud fetch:', error);
        throw error; 
    }
}

// Exporta la función para que pueda ser usada en otros archivos
export default fetchRequest;
