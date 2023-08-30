import { ComponentFixture, TestBed } from '@angular/core/testing';

import { SymptomListComponent } from './symptom-list.component';

describe('SymptomListComponent', () => {
  let component: SymptomListComponent;
  let fixture: ComponentFixture<SymptomListComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [SymptomListComponent]
    });
    fixture = TestBed.createComponent(SymptomListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
