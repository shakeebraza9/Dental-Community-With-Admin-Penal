<?php


$formData = array(
    
    '1' => array(
            "heading" => "Feedback Survey",
            "type" => "feedbackForm",
            'data' => array(
                
                array(
                'lable' => "Your Name:",
                'name' => "Your Name",
                'type' => "text",
                'placeholder' => 'Your Name',
                'value' => '',
                ),
                
                array(
                'lable' => "Your Practice Name:",
                'name' => "Practice Name",
                'type' => "text",
                'placeholder' => 'Your Practice Name',
                'value' => '',
                ),
                
                array(
                'lable' => "Email:",
                'name' => "Email",
                'type' => "email",
                'placeholder' => 'Email',
                'value' => '',
                ),
                
                array(
                'lable' => "Your Contact No:",
                'name' => "Contact No",
                'type' => "text",
                'placeholder' => 'Contact No',
                'value' => '',
                ),
                
                
                
                array(
                'lable' => "How did you find the training session?",
                'type' => "radio",
                'placeholder' => '',
                'value' => '',
                'options' => array(
                    array(
                        'lable' => 'Above average',
                        'value' => 'above average'
                        ),
                    array(
                        'lable' => 'Average',
                        'value' => 'average',
                        ),
                    array(
                        'lable' => 'Below average',
                        'value' => 'below average',
                        ),
                   
                    )
            ),
            
                array(
                'lable' => "Do you feel confident in using the software?",
                'type' => "radio",
                'placeholder' => '',
                'value' => '',
                'options' => array(
                    array(
                        'lable' => 'Yes',
                        'value' => 'yes'
                        ),
                    array(
                        'lable' => 'No',
                        'value' => 'No',
                        )
                    )
                
                ),
    
                array(
                'lable' => "How would you rate your trainer?",
                'type' => "rating",
                )
            )
   
        ),

    '2' => array(
            "heading" => "Feedback Survey 2",
            "type" => "feedbackForm2",
            
            'data' => array(
                array(
                'lable' => "What is your name?",
                'type' => "text",
                'name' => "Name",
                'placeholder' => "What is your name?",
                'value' => '',
                ),
                
                array(
                'lable' => "your email",
                'type' => "email",
                'name' => "Email",
                'placeholder' => "email",
                'value' => '',
                ),
            
                array(
                'lable' => "Sugesstion",
                'type' => "email",
                'name' => "Sugesstion",
                'type' => "textarea",
                
                'placeholder' => 'Give your suggestion',
                'value' => '',
                ),
                
                
                array(
                'lable' => "Your interest?",
                'type' => "checkbox",
                'placeholder' => 'your index?',
                'value' => '',
                'options' => array(
                    array(
                        'lable' => 'Above average',
                        'value' => 'above average'
                        ),
                    array(
                        'lable' => 'Average',
                        'value' => 'average',
                        ),
                    array(
                        'lable' => 'Below average',
                        'value' => 'below average',
                        ),
                   
                    )
            ),
    
                array(
                'lable' => "How would you rate your trainer?",
                'type' => "rating",
                )
            )
   
        ),
        
    '3' => array(
            "heading" => "Feedback Survey3",
            "type" => "feedbackForm",
            'data' => array(
                array(
                'lable' => "What is your name?",
                'type' => "radio",
                'placeholder' => 'What is your name?',
                'value' => '',
                'options' => array(
                    array(
                        'lable' => 'Above average',
                        'value' => 'above average'
                        ),
                    array(
                        'lable' => 'Average',
                        'value' => 'average',
                        ),
                    array(
                        'lable' => 'Below average',
                        'value' => 'below average',
                        ),
                   
                    )
            ),
            
                array(
                'lable' => "Do you feel confident in using the software?",
                'type' => "radio",
                'placeholder' => '',
                'value' => '',
                'options' => array(
                    array(
                        'lable' => 'Yes',
                        'value' => 'yes'
                        ),
                    array(
                        'lable' => 'No',
                        'value' => 'No',
                        )
                    )
                
                ),
    
                array(
                'lable' => "How would you rate your trainer?",
                'type' => "rate",
                )
            )
   
        ),
    
    
    );
    
?>