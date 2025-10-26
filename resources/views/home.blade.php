@extends('layouts.app')

@section('content')
<!-- Modal de Confirmación -->
<div id="uploadModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <!-- Ícono de éxito/error -->
            <div id="modalIcon" class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                <i id="modalIconType" class="fas fa-check text-green-600 text-xl"></i>
            </div>
            
            <!-- Título -->
            <h3 id="modalTitle" class="text-lg leading-6 font-medium text-gray-900 mt-2">¡Audio Subido Exitosamente!</h3>
            
            <!-- Mensaje -->
            <div class="mt-2 px-7 py-3">
                <p id="modalMessage" class="text-sm text-gray-500">
                    Tu archivo de audio ha sido procesado correctamente y está listo para usar.
                </p>
            </div>
            
            <!-- Botones -->
            <div class="items-center px-4 py-3">
                <button id="okButton" class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300">
                    Continuar
                </button>
            </div>
        </div>
    </div>
</div>
<div class="space-y-6">
    <!-- Welcome Banner -->
    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Bienvenido a AudioGestor</h1>
                <p class="text-gray-600 mt-2">Gestiona tu biblioteca de audio de manera eficiente</p>
            </div>
            <div class="bg-blue-50 rounded-lg p-4">
                <i class="fas fa-music text-blue-500 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Audios -->
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
            <div class="flex items-center">
                <div class="bg-blue-100 rounded-lg p-3 mr-4">
                    <i class="fas fa-file-audio text-blue-600"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Total de Audios</p>
                    <p class="text-2xl font-bold text-gray-900">0</p>
                </div>
            </div>
        </div>

        <!-- Playlists -->
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
            <div class="flex items-center">
                <div class="bg-green-100 rounded-lg p-3 mr-4">
                    <i class="fas fa-list text-green-600"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Playlists</p>
                    <p class="text-2xl font-bold text-gray-900">0</p>
                </div>
            </div>
        </div>

        <!-- Espacio Usado -->
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
            <div class="flex items-center">
                <div class="bg-yellow-100 rounded-lg p-3 mr-4">
                    <i class="fas fa-hdd text-yellow-600"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Espacio Usado</p>
                    <p class="text-2xl font-bold text-gray-900">0 MB</p>
                </div>
            </div>
        </div>

        <!-- Etiquetas -->
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
            <div class="flex items-center">
                <div class="bg-purple-100 rounded-lg p-3 mr-4">
                    <i class="fas fa-tags text-purple-600"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Etiquetas</p>
                    <p class="text-2xl font-bold text-gray-900">0</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity & Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Actividad Reciente -->
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Actividad Reciente</h2>
            <div class="space-y-4">
                <div class="flex items-center justify-between py-3 border-b border-gray-100">
                    <div class="flex items-center">
                        <div class="bg-gray-100 rounded-lg p-2 mr-3">
                            <i class="fas fa-upload text-gray-600"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">No hay actividad reciente</p>
                            <p class="text-xs text-gray-500">Sube tu primer audio para comenzar</p>
                        </div>
                    </div>
                    <span class="text-xs text-gray-500">-</span>
                </div>
            </div>
        </div>

        <!-- Acciones Rápidas -->
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Acciones Rápidas</h2>
            <div class="grid grid-cols-2 gap-4">
                <form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data" class="flex flex-col items-center justify-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-colors group" id="uploadForm">
                   @csrf
                   <i class="fas fa-upload text-gray-400 group-hover:text-blue-500 text-xl mb-2"></i>
                   <span class="text-sm font-medium text-gray-700 group-hover:text-blue-700">Subir Audios</span>
                   <input type="file" name="audios[]" id="audios" class="hidden" onchange="handleFileSelect(this)" multiple accept=".mp3,.wav,.ogg">
                   <label for="audios" class="cursor-pointer mt-2 text-blue-500 hover:text-blue-700">Seleccionar archivos</label>
                   <div id="fileInfo" class="mt-2 text-xs text-gray-500 hidden"></div>
                   
                   <!-- Lista de archivos seleccionados -->
                   <div id="filePreview" class="w-full mt-4 hidden">
                       <div class="bg-gray-50 rounded-lg p-3">
                           <h4 class="text-sm font-medium text-gray-700 mb-2">Archivos seleccionados:</h4>
                           <div id="fileList" class="space-y-2 max-h-40 overflow-y-auto"></div>
                           <div id="totalSize" class="mt-2 text-xs text-gray-500 border-t pt-2"></div>
                       </div>
                   </div>
                   
                   <button type="submit" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-700 flex items-center" id="submitButton">
                       <span>Subir</span>
                       <div id="loadingSpinner" class="hidden ml-2">
                           <i class="fas fa-spinner fa-spin"></i>
                       </div>
                   </button>
               </form>
                <a href="#" class="flex flex-col items-center justify-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-green-500 hover:bg-green-50 transition-colors group">
                    <i class="fas fa-plus text-gray-400 group-hover:text-green-500 text-xl mb-2"></i>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-green-700">Nueva Playlist</span>
                </a>
                <a href="#" class="flex flex-col items-center justify-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-purple-500 hover:bg-purple-50 transition-colors group">
                    <i class="fas fa-tags text-gray-400 group-hover:text-purple-500 text-xl mb-2"></i>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-purple-700">Gestionar Etiquetas</span>
                </a>
                <a href="#" class="flex flex-col items-center justify-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-yellow-500 hover:bg-yellow-50 transition-colors group">
                    <i class="fas fa-chart-bar text-gray-400 group-hover:text-yellow-500 text-xl mb-2"></i>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-yellow-700">Ver Estadísticas</span>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('uploadModal');
    const modalIcon = document.getElementById('modalIcon');
    const modalIconType = document.getElementById('modalIconType');
    const modalTitle = document.getElementById('modalTitle');
    const modalMessage = document.getElementById('modalMessage');
    const okButton = document.getElementById('okButton');
    const uploadForm = document.getElementById('uploadForm');
    const submitButton = document.getElementById('submitButton');
    const loadingSpinner = document.getElementById('loadingSpinner');

    // Mostrar modal automáticamente si hay mensajes de sesión
    @if(session('success'))
        showModal('success', '¡Audio Subido Exitosamente!', '{{ session('success') }}');
    @endif

    @if(session('error'))
        showModal('error', 'Error al Subir Audio', '{{ session('error') }}');
    @endif

    // Función para mostrar el modal
    function showModal(type, title, message) {
        // Configurar estilos según el tipo
        if (type === 'success') {
            modalIcon.className = 'mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100';
            modalIconType.className = 'fas fa-check text-green-600 text-xl';
            okButton.className = 'px-4 py-2 bg-green-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-300';
        } else {
            modalIcon.className = 'mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100';
            modalIconType.className = 'fas fa-exclamation-triangle text-red-600 text-xl';
            okButton.className = 'px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300';
        }

        modalTitle.textContent = title;
        modalMessage.textContent = message;
        modal.classList.remove('hidden');
    }

    // Cerrar modal al hacer click en OK
    okButton.addEventListener('click', function() {
        modal.classList.add('hidden');
    });

    // Cerrar modal al hacer click fuera del contenido
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.classList.add('hidden');
        }
    });

    // Manejar selección de archivos múltiples
    function handleFileSelect(input) {
        const fileInfo = document.getElementById('fileInfo');
        const filePreview = document.getElementById('filePreview');
        const fileList = document.getElementById('fileList');
        const totalSizeElement = document.getElementById('totalSize');
        
        if (input.files && input.files.length > 0) {
            let totalSize = 0;
            let hasInvalidFile = false;
            
            // Limpiar lista anterior
            fileList.innerHTML = '';
            
            // Validar cada archivo y agregar a la lista
            for (let i = 0; i < input.files.length; i++) {
                const file = input.files[i];
                const fileSizeMB = (file.size / (1024 * 1024)).toFixed(2);
                totalSize += file.size;
                
                // Validar tamaño individual
                if (fileSizeMB > 20) {
                    alert(`El archivo "${file.name}" es demasiado grande. El tamaño máximo por archivo es 20MB.`);
                    hasInvalidFile = true;
                    break;
                }
                
                // Crear elemento de archivo en la lista
                const fileItem = document.createElement('div');
                fileItem.className = 'flex items-center justify-between bg-white p-2 rounded border border-gray-200';
                fileItem.innerHTML = `
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-file-audio text-blue-500"></i>
                        <div>
                            <div class="text-sm font-medium text-gray-900 truncate max-w-xs">${file.name}</div>
                            <div class="text-xs text-gray-500">${fileSizeMB} MB</div>
                        </div>
                    </div>
                    <button type="button" onclick="removeFile(${i})" class="text-red-500 hover:text-red-700">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                fileList.appendChild(fileItem);
            }
            
            if (hasInvalidFile) {
                input.value = '';
                fileInfo.classList.add('hidden');
                filePreview.classList.add('hidden');
                return;
            }
            
            // Validar tamaño total (100MB máximo)
            const totalSizeMB = (totalSize / (1024 * 1024)).toFixed(2);
            if (totalSizeMB > 100) {
                alert(`El tamaño total de los archivos (${totalSizeMB} MB) excede el límite de 100MB.`);
                input.value = '';
                fileInfo.classList.add('hidden');
                filePreview.classList.add('hidden');
                return;
            }
            
            // Mostrar información de los archivos seleccionados
            if (input.files.length === 1) {
                fileInfo.textContent = `1 archivo seleccionado (${totalSizeMB} MB)`;
            } else {
                fileInfo.textContent = `${input.files.length} archivos seleccionados (${totalSizeMB} MB)`;
            }
            fileInfo.classList.remove('hidden');
            
            // Mostrar lista de archivos
            totalSizeElement.textContent = `Tamaño total: ${totalSizeMB} MB`;
            filePreview.classList.remove('hidden');
            
            console.log('Archivos seleccionados:', Array.from(input.files).map(f => f.name).join(', '));
        } else {
            fileInfo.classList.add('hidden');
            filePreview.classList.add('hidden');
        }
    }
    
    // Función para remover archivo de la lista
    function removeFile(index) {
        const input = document.getElementById('audios');
        const files = Array.from(input.files);
        
        // Remover archivo del array
        files.splice(index, 1);
        
        // Crear nuevo DataTransfer con los archivos restantes
        const dataTransfer = new DataTransfer();
        files.forEach(file => dataTransfer.items.add(file));
        
        // Actualizar input files
        input.files = dataTransfer.files;
        
        // Actualizar la vista
        handleFileSelect(input);
    }

    // Manejar envío del formulario
    uploadForm.addEventListener('submit', function(e) {
        const fileInput = document.getElementById('audios');
        
        if (!fileInput.files || fileInput.files.length === 0) {
            e.preventDefault();
            showModal('error', 'Archivos Requeridos', 'Por favor selecciona al menos un archivo de audio para subir.');
            submitButton.disabled = false;
            loadingSpinner.classList.add('hidden');
            submitButton.querySelector('span').textContent = 'Subir';
            return;
        }

        // Validar cantidad máxima de archivos (opcional, por ejemplo 10 archivos máximo)
        if (fileInput.files.length > 10) {
            e.preventDefault();
            showModal('error', 'Demasiados Archivos', 'Puedes subir un máximo de 10 archivos a la vez.');
        }

        // Mostrar loading state
        submitButton.disabled = true;
        loadingSpinner.classList.remove('hidden');
        if (fileInput.files.length === 1) {
            submitButton.querySelector('span').textContent = 'Subiendo...';
        } else {
            submitButton.querySelector('span').textContent = `Subiendo ${fileInput.files.length} archivos...`;
        }
    });

    // Manejar tecla Escape para cerrar modal
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            modal.classList.add('hidden');
        }
    });
});
</script>
@endsection
