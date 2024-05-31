<style>
    table {
        width: 50%;
        border-collapse: collapse;
    }
    table, th, td {
        border: 1px solid black;
    }
    th, td {
        padding: 5px; /* Adjust the padding as needed */
        text-align: left;
    }
    th {
        background-color: #f2f2f2;
    }
</style>

<x-machine-learning_layout>


    <div class="container-fluid custom-homepage-container">
        <div class="row justify-content-center">
            <div class="col-md-6"> <!-- Adjust the column width as needed -->


                <div class="p-4 custom-card-container">
                    <h1> MNIST</h1>
                    <h4> Dataset Creation </h4>
                    <p>
                    MNIST is a popular database of handwritten digits for training and testing machine learning models. 
                    To add a personal touch, I decided to create my own dataset of handwritten digits using the OpenCV library in Python for image analysis. 
                    To create the initial dataset, I filled a 10x20 grid with digits in random order to generate variation in the samples. 
                    After identifying the solid black lines to isolate the cells, the bounding rectangle of each digit was centered and scaled to a 16x16 pixel image. 
                    To increase the diversity and number of training samples, I applied rotation (+/- 15 degrees) and horizontal shifting to the original images, expanding the number of samples from 200 to 3000.
                    </p>

                    <div style="padding:10;">
                        <img class="custom-screenshot" src="{{ asset('images/posts/MNIST/creating_dataset.jpg') }}" alt="Image 1" width="600" height='auto'> 
                    </div>

                    <h4> Models </h4>
                    <p>
                    Three types of models were trained on the data. 
                    A Support Vector Machine (SVM) and Random Forest Classifier were implemented in Scikit-learn and a Convolution Neural Network (CNN) was built in Pytorch. 
                    Notably, only the CNN incorporates distance relationships between the pixels through convolutions. 
                    The dataset was split into 80% training and 20% validation using 5-fold cross-validation for model tuning. 
                    Finally, the models were trained on the entire dataset and tested on a separate sample containing the first 200 digits of pi. 
                    </p>

                    <p>
                    <h4> Regularization </h4>
                    Due to the limited number of samples relative to pixel features, regularization was essential to prevent overfitting.
                    <ul>
                        <li> SVM -> L2 penalty </li>
                        <li> Random Forest -> Number of estimators, maximum tree depth, pruning, and minimum leaf size </li>
                        <li> CNN -> Simple architecture, L2 penalty term, and early stopping </li>
                    </ul>                  
                    
                    SVMs cannot directly perform many-many classification like multinomial logistic regression (aka softmax regression). 
                    Options include one-vs-one (fitting a model for each class pair) or one-vs-all (fitting a model for each class). 
                    One-vs-one is generally preferred due to SVMs scaling poorly with large datasets. 
                    SVMs generate linear decision boundaries, but can utilize the “kernel trick” to project data onto high/infinite dimensional spaces where linear decision boundaries correspond to nonlinear boundaries in the original feature space. 
                    However, this trick isn’t compatible with mini-batch SGD optimization.
                </p>

                <p>
                    The following details the CNN architecture where the basics of each layer are described in this post:
                    {{-- <a href="/machine-learning/posts/feature_engineering"> this post.</a> --}}
                    <ol>
                        <li> Input (1x16x16 pixels) </li>
                        <li> Convolution (3x3 kernel) </li>
                        <li> Max-pooling (2x2 kernel) </li>
                        <li> Convolution (3x3 kernel) </li>
                        <li> Max-pooling (2x2 kernel) </li>
                        <li> Fully connected (40 neurons) </li>
                        <li> Output (10 neurons) </li>
                    </ol>
                    </p>




                    <h4> Results </h4>
                    <p>
                    The table shows a summary of model performance (sorted by fit times), giving the mean and standard deviation of the cross-validation scores and final test accuracy. 
                    The random seeds were specified to ensure consistency of the algorithms. 
                    In all cases, the test accuracy was higher than the cross-validation accuracy suggesting a few difficult outliers in the training set.  
                    </p>
                    <p>
                    <table>
                        <tr>
                            <th>Model</th>
                            <th>Cross Validation</th>
                            <th>Test</th>
                        </tr>
                        <tr>
                            <td>Linear SVM (SGD)</td>
                            <td>95.9 +/- (2.6) %</td>
                            <td>97.0%</td>
                        </tr>
                        <tr>
                            <td>SVM (with RBF kernel)</td>
                            <td>98.8 +/- (1.0) %</td>
                            <td>100%</td>
                        </tr>
                        <tr>
                            <td>Random Forest</td>
                            <td>97.6 +/- (2.6) %</td>
                            <td>99.0%</td>
                        </tr>
                        <tr>
                            <td>CNN</td>
                            <td>97.7 +/- (1.1) %</td>
                            <td>98.5%</td>
                        </tr>
                    </table>
                </p>
                    <p>
                    The Linear SVM was the fastest algorithm, but produced the lowest accuracy. 
                    Implementing a radial basis function (RBF) kernel led to perfect test classification.  
                    The Random Forest and CNN behaved similarly, and struggled to distinguish specific classes such as 4s/9s and 8s/9s indicating a need for more training data for these classes. 

                    It should be noted that the CNN parameters were coarsely tuned, but better performance may be achieved. 
                    Specifically, Adam trained faster but appeared to give less consistent results than SGD optimization. 
                     
                    </p>

                    <div style="padding:10;">
                        <img class="custom-screenshot" src="{{ asset('images/posts/MNIST/svm_testing.jpg') }}" alt="Image 1" width="400" height='auto'> 
                    </div>

                    <p>
                    This project gave firsthand experience with the strengths and limitations of different algorithms. 
                    Fast-fitting models like SVMs allow quick iteration, making classical machine learning still very relevant in the age of deep learning. 
                    Additionally, tuning neural networks requires more intuition and practice as there is less theory to guide the design of architecture. 
                    The dataset may be small and limited to my personal handwriting style, but it did show how machine learning can perform non-trivial tasks very quickly using built-in libraries. 
                    It would be interesting to see how well these results generalize to different writing styles. 
                    </p>

                </div>
            </div>
        </div>

    </div>
</x-machine-learning_layout>