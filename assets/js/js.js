window.addEventListener('load', async (event) => {
    console.log("Cargando datos en la página de inicio");

    // Función que maneja la solicitud de preguntas y actualización del contenido
    const loadData = async () => {
        const contentDiv = document.getElementById('dynamic-content');
        
        // Hacer una solicitud a la API para obtener las preguntas activas
        const responseQuestions = await fetch('/api/pregunta/activa');
        
        // Verificar si la respuesta fue exitosa
        if (!responseQuestions.ok) {
            throw new Error('Error en la solicitud de preguntas');
        }

        const question = await responseQuestions.json();

        console.log(question); // Verificar el contenido de la respuesta
        console.log(question.id);
        // Limpiar el contenido previo
        contentDiv.innerHTML = '';

        // Verificar si se obtuvieron preguntas
        if (question.id > 0) {
            // Iterar sobre las preguntas obtenidas
            
                const questionElement = document.createElement('div');
                questionElement.classList.add('question');
                questionElement.style.display = 'flex'; // Usar flexbox para alineación horizontal
                questionElement.style.flexWrap = 'wrap'; // Asegura que el contenido no se desborde
                questionElement.style.marginBottom = '20px'; // Espaciado entre preguntas
                console.log(question.id);
                // Crear el contenido de la pregunta
                questionElement.innerHTML = `
                    <div class="question-content" style="flex: 1; padding-right: 20px;">
                        <h2>${question.descripcion}</h2>
                        <form id="question-form-${question.id}">
                            <div>
                                <label>
                                    <input type="radio" name="answer" value="opcion1" /> ${question.opcion1}
                                </label>
                            </div>
                            <div>
                                <label>
                                    <input type="radio" name="answer" value="opcion2" /> ${question.opcion2}
                                </label>
                            </div>
                            ${question.opcion3 ? `
                            <div>
                                <label>
                                    <input type="radio" name="answer" value="opcion3" /> ${question.opcion3}
                                </label>
                            </div>
                            ` : ''}
                            ${question.opcion4 ? `
                            <div>
                                <label>
                                    <input type="radio" name="answer" value="opcion4" /> ${question.opcion4}
                                </label>
                            </div>
                            ` : ''}
                        </form>
                        <p><strong>Correcta:</strong> ${question.correcta}</p>
                        <p><strong>Fecha de inicio:</strong> ${question.fechaInicio}</p>
                        <p><strong>Fecha de fin:</strong> ${question.fechaFin ? question.fechaFin : 'Sin fecha de fin'}</p>
                    </div>
                `;
                console.log(question.id);

                // Agregar la pregunta al contenedor
                contentDiv.appendChild(questionElement);

                // Hacer una solicitud para obtener los resultados de las respuestas de esta pregunta
                const responseResults = await fetch('/api/pregunta/estadistica/'+question.id);
                
                // Verificar si la respuesta de resultados fue exitosa
                if (!responseResults.ok) {
                    throw new Error(`Error en la solicitud de resultados para la pregunta ${question.id}`);
                }

                const resultsData = await responseResults.json();

                console.log(resultsData); // Verificar los resultados de la respuesta
                
                // Crear el contenedor del gráfico
                const chartContainer = document.createElement('div');
                chartContainer.classList.add('chart-container');
                chartContainer.style.flex = '1'; // Ocupa el 50% del ancho del contenedor

                // Crear el canvas para la gráfica
                const chartCanvas = document.createElement('canvas');
                chartContainer.appendChild(chartCanvas);
                questionElement.appendChild(chartContainer);
                
                // Configurar el gráfico
                const ctx = chartCanvas.getContext('2d');
                const labels = ['Opción 1', 'Opción 2', 'Opción 3', 'Opción 4'];
                const dataSet = [
                    resultsData[0]?.cantidad || 0, 
                    resultsData[1]?.cantidad || 0,
                    resultsData[2]?.cantidad || 0, 
                    resultsData[3]?.cantidad || 0, 
                    10
                ];

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Respuestas',
                            data: dataSet,
                            backgroundColor: ['#4CAF50', '#2196F3', '#FF9800', '#F44336'],
                            borderColor: ['#4CAF50', '#2196F3', '#FF9800', '#F44336'],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            
        } else {
            contentDiv.innerHTML = '<p>No hay preguntas activas en este momento o no tienes permiso para verlas.</p>';
        }
    };

    // Cargar los datos al cargar la página
    await loadData();

    // Actualizar los datos cada 10 segundos (10000 milisegundos)
    setInterval(async () => {
        await loadData();
    }, 5000);
});

