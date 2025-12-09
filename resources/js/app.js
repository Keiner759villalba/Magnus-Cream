// resources/js/app.js (o el archivo donde manejas tu lógica)

// Tus importaciones existentes (Alpine, Bootstrap, etc.)
import './bootstrap';
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// ----------------------------------------------------
// Lógica Específica para la Creación de Ventas
// ----------------------------------------------------

document.addEventListener('DOMContentLoaded', function () {
    // CONDICIONAL: Solo ejecuta el código si el contenedor de productos existe en la página
    const productosContainer = document.getElementById('productos-container');
    const addProductoButton = document.getElementById('add-producto');
    
    // Si no estamos en la vista de crear venta, el script no hace nada.
    if (!productosContainer || !window.productosData) {
        return; 
    }

    let productoIndex = 0;
    
    // Los datos vienen ahora de la variable global definida en el Blade
    const productos = window.productosData;

    // Función para generar las opciones del campo <select>
    function getProductoOptions() {
        let options = '<option value="">-- Selecciona un producto --</option>';
        productos.forEach(p => { // Usamos 'productos' (que es window.productosData)
            options += `<option value="${p.id}">${p.nombre} — S/${p.precio_venta} (Stock: ${p.stock})</option>`;
        });
        return options;
    }

    // Función para crear la plantilla HTML de una fila de producto
    function createProductoRow(index) {
        const row = document.createElement('div');
        row.className = 'producto-row p-3 border rounded-lg bg-white shadow-sm flex flex-col sm:flex-row sm:space-x-4 space-y-3 sm:space-y-0 items-end';
        row.innerHTML = `
            <div class="flex-1 w-full">
                <label class="text-xs font-medium block mb-1">Producto</label>
                <select name="productos[${index}][producto_id]" required class="w-full rounded border-gray-200 px-3 py-2">
                    ${getProductoOptions()}
                </select>
            </div>
            <div class="w-1/4 sm:w-auto">
                <label class="text-xs font-medium block mb-1">Cantidad</label>
                <input name="productos[${index}][cantidad]" type="number" min="1" value="1" class="w-full rounded border-gray-200 px-3 py-2 text-center" required>
            </div>
            <button type="button" class="remove-producto bg-red-500 text-white p-2 rounded-full h-10 w-10 flex items-center justify-center transition duration-150 ease-in-out hover:bg-red-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 pointer-events-none" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            </button>
        `;
        return row;
    }

    // Lógica de manejo de eventos
    function addFirstProducto() {
        productosContainer.appendChild(createProductoRow(productoIndex++));
    }

    addProductoButton.addEventListener('click', function() {
        productosContainer.appendChild(createProductoRow(productoIndex++));
    });

    productosContainer.addEventListener('click', function(e) {
        const removeButton = e.target.closest('.remove-producto');
        if (removeButton) {
            const row = removeButton.closest('.producto-row');
            if (productosContainer.childElementCount > 1) {
                row.remove();
            } else {
                alert('Debe haber al menos un producto en la venta.');
            }
        }
    });

    // Inicializa la primera fila
    addFirstProducto();
});