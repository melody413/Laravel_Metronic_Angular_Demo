import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CreateMedicineComponent } from './create-medicine.component';

describe('CreateMedicineComponent', () => {
  let component: CreateMedicineComponent;
  let fixture: ComponentFixture<CreateMedicineComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [CreateMedicineComponent]
    });
    fixture = TestBed.createComponent(CreateMedicineComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
