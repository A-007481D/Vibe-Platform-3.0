<div class="messenger-sendCard">
    <form id="message-form" method="POST" action="{{ route('send.message') }}" enctype="multipart/form-data">
        @csrf
        <label>
            <span class="fas fa-plus-circle"></span>
            <input disabled='disabled' type="file" class="upload-attachment" name="file" 
                accept=".{{implode(', .',config('chatify.attachments.allowed_images'))}}, .{{implode(', .',config('chatify.attachments.allowed_files'))}}" />                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       
        </label>
        <button class="emoji-button"><span class="fas fa-smile"></span></button>
        
                                                                                                                                                                                                                                                                                                                    <button id="send-location-btn" class="btn btn-primary" 
            style="background: none; border: none; padding: 5px; display: inline-flex; align-items: center;">
            <svg fill="currentColor" height="18px" width="18px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" 
                style="color: inherit; transition: color 0.3s;">
                <path d="M18.3,4.4C17.4,1.8,14.9,0,12,0C8.8,0,6.1,2.3,5.4,5.3L0,3v17.2l8,3.4l8-3l8,3.4V6.8L18.3,4.4z M9,14.4 
                c1.2,1.4,2.3,2.2,2.4,2.3l0.7,0.6l0.6-0.6c0.3-0.3,0.7-0.7,1.1-1c0.4-0.4,0.8-0.8,1.2-1.2v4.3l-6,2.3V14.4z M12,2 
                c2.6,0,4.8,2.1,4.8,4.8c0,1.9-0.8,3.4-1.8,4.7l0,0l0,0c-0.8,1-1.7,1.9-2.6,2.7c-0.1,0.1-0.3,0.3-0.4,0.4
                c-1.8-1.6-4.8-5-4.8-7.8C7.2,4.1,9.4,2,12,2z M2,6l3.3,1.4c0.2,1.5,0.9,3,1.7,4.4V21l-5-2.1V6z M22,21l-5-2.1v-6.7
                c1-1.5,1.8-3.2,1.8-5.4L22,8.2V21z"></path>
                <circle cx="12" cy="7" r="2"></circle>
            </svg>
        </button>

        <textarea readonly='readonly' name="message" class="m-send app-scroll" placeholder="Type a message.."></textarea>
        <button disabled='disabled' class="send-button"><span class="fas fa-paper-plane"></span></button>
    </form>
</div>
