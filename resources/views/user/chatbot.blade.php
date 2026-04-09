<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Asisten Pintar (Chatbot)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex flex-col" style="height: 70vh;">
                
                <!-- Chat Header -->
                <div class="bg-indigo-600 text-white p-4 flex items-center shadow">
                    <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center mr-3 shadow-inner text-indigo-600 text-xl font-bold">
                        🤖
                    </div>
                    <div>
                        <h3 class="font-bold text-lg leading-tight">Asisten Gudang</h3>
                        <p class="text-xs text-indigo-200">Tanya Ketersediaan Alat 24/7</p>
                    </div>
                </div>

                <!-- Chat Area -->
                <div id="chat-box" class="flex-1 p-6 overflow-y-auto bg-gray-50 dark:bg-gray-900 space-y-4">
                    <!-- Bot Greeting -->
                    <div class="flex">
                        <div class="bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 p-3 rounded-2xl rounded-tl-none shadow-sm max-w-[80%]">
                            <p class="text-sm">Halo <b>{{ auth()->user()->name }}</b>! Saya Asisten Gudang Anda. Ingin tahu stok alat atau mengecek kondisi spesifik alat yang ingin dipinjam? Ketik saja di sini!</p>
                        </div>
                    </div>
                </div>

                <!-- Input Area -->
                <div class="p-4 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 flex items-center gap-2">
                    <input type="text" id="chat-input" placeholder="Tanya tentang alat di sini..." class="flex-1 rounded-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm text-sm" autocomplete="off" onkeypress="if(event.key === 'Enter') sendMessage()">
                    <button onclick="sendMessage()" class="bg-indigo-600 hover:bg-indigo-700 text-white w-10 h-10 rounded-full flex items-center justify-center transition-transform transform hover:scale-105 focus:outline-none shadow text-lg leading-none cursor-pointer">
                        ➤
                    </button>
                </div>
                
            </div>
        </div>
    </div>

    <script>
        const chatBox = document.getElementById('chat-box');
        const chatInput = document.getElementById('chat-input');

        function appendMessage(isUser, htmlMessage) {
            const wrapper = document.createElement('div');
            wrapper.className = isUser ? "flex justify-end" : "flex";
            
            const msgBubble = document.createElement('div');
            msgBubble.className = isUser 
                ? "bg-indigo-600 text-white p-3 rounded-2xl rounded-tr-none shadow-sm max-w-[80%] text-sm" 
                : "bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 p-3 rounded-2xl rounded-tl-none shadow-sm max-w-[80%] text-sm";
            
            msgBubble.innerHTML = htmlMessage;
            wrapper.appendChild(msgBubble);
            chatBox.appendChild(wrapper);
            
            // Scroll to bottom
            chatBox.scrollTop = chatBox.scrollHeight;
        }

        async function sendMessage() {
            const message = chatInput.value.trim();
            if (!message) return;

            // 1. Tampilkan pesan user
            appendMessage(true, message);
            chatInput.value = '';

            // 2. Tampilkan indikator loading (opsional, ditiadakan untuk kecepatan)
            
            try {
                // 3. Request ke backend
                const response = await fetch("{{ route('user.chatbot.respond') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ message: message })
                });

                if (response.ok) {
                    const data = await response.json();
                    appendMessage(false, data.reply);
                } else {
                    appendMessage(false, "<i>Maaf, terjadi kesalahan server.</i>");
                }
            } catch (error) {
                appendMessage(false, "<i>Maaf, jaringan terputus.</i>");
            }
        }
    </script>
</x-app-layout>
